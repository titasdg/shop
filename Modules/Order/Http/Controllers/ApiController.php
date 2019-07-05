<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Order\Transformers\OrderResource;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\Customer;
use Modules\Order\Entities\OrderedProduct;
use Modules\Order\Entities\Reserved;
use Modules\Product\Entities\Product;
use App\Services\PayUService\Exception;
use Modules\Settings\Entities\Settings;
use Modules\Settings\Entities\Shipping;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = Order::latest()->paginate(25);

        return OrderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(Request $request)
    {

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }
*/
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    /* Nenaudojamas
    public function update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order, 200);
    }
*/
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);

        return response()->json(null, 204);
    }
    public function storeOrder(Request $request)
    {
        try {
            foreach($request->cart as $product)
            {
                $valible=true;
                $findProduct=Product::findorFail($product['id']);
                if($findProduct->quantity<(int)$product['quantity'])
                {
                    $valible=false;
                    return response()->json($findProduct, 406);
                    break;
                }
            }
            if($valible==true)
            {
                $userInfo=$request->userInfo;
                $randomNumber=rand(100000,1000000);
                while(Order::where('id', '=', $randomNumber)->count()>0){
                    $randomNumber=rand(100000,1000000);
                }
              
               
                $customer=Customer::create([
                    'name' =>$userInfo['name'],
                    'last_name' =>$userInfo['lastName'],
                    'email' =>$userInfo['email'],
                    'phone' =>$userInfo['phone'],
                    'company' =>$userInfo['company'],
                    'order_id' =>$randomNumber
                ]);
                $allProductsPrice=0;
                foreach($request->cart as $product)
            {
                $findProduct=Product::findorFail($product['id']);
                    OrderedProduct::create([
                        'order_id' =>$randomNumber,
                        'product_id' => $product['id'],
                        'quantity' =>$product['quantity']
                        ]);
                $allProductsPrice+=$product['quantity']*$findProduct['discount_price'];
            }

            $order=Order::create([
                'address' => $userInfo['address'],
                'addressExtra' => $userInfo['addressExtra'],
                'city' => $userInfo['city'],
                'country' => $userInfo['country'],
                'post_code' => $userInfo['postCode'],
                'payment_method' => $userInfo['paymentType'],
                'shipping' => $userInfo['shipping'],
                'id' =>$randomNumber,
                'price'=> $allProductsPrice
            ]);
                
                $orderId=$order->id;
              $this->sendOrderEmail($request,$allProductsPrice,$orderId);

            }
            }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }


    public function status($id,$value)
    { 
        
        try {
            $order = Order::findOrFail($id);
            $integer=(integer)$value;
            if($integer==2){
                if($order->paid==1)
                {
                    $order->update([
                        'status'=>$integer,
                        'paid'=>1
                    ]);
                }
                else{
                    $orderedProducts=OrderedProduct::where('order_id','=',$id)->get();
                    foreach($orderedProducts as $product)
                    {
                        $findProduct=Product::findorFail($product['product_id']);
                        $sum=$findProduct->quantity-$product['quantity'];
                        $findProduct->update(['quantity'=>$sum]);
                    }
                    $order->update([
                        'status'=>$integer,
                        'paid'=>1
                    ]);
                }
            }
            else if($integer==1)
            {
                $orderedProducts=OrderedProduct::where('order_id','=',$id)->get();
               foreach($orderedProducts as $product)
                {
                    $findProduct=Product::findorFail($product['product_id']);
                    $sum=$findProduct->quantity-$product['quantity'];
                    $findProduct->update(['quantity'=>$sum]);
                }
                $order->update([
                    'status'=>$integer,
                    'paid'=>1
                ]);
            }
            else if($integer==0)
            {   
                $orderedProducts=OrderedProduct::where('order_id','=',$id)->get();
                foreach($orderedProducts as $product)
                {
                    $findProduct=Product::findorFail($product['product_id']);
                    $sum=$findProduct->quantity+$product['quantity'];
                    $findProduct->update(['quantity'=>$sum]);
                }
                $order->update([
                    'status'=>$integer,
                    'paid'=>0
                ]);
            }
            }
            
        catch(\Exception $e){
            return $e->getMessage();

        } 
    }








    public function sendOrderEmail(Request $request,$allProductsPrice,$orderId)
    {
        $mail = new \PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 1;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->CharSet = 'UTF-8';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = 'smtp.gmail.com';                               // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                       // Enable SMTP authentication
            $mail->Username = env('MAIL_USERNAME','default_value');                     // SMTP username
            $mail->Password = env('MAIL_PASSWORD','default_value');                         // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = env('MAIL_PORT',587);                                                      // TCP port to connect to
            //Recipients
            $mail->setFrom(env('MAIL_USERNAME','default_value')    );
            $mail->addAddress($request->userInfo['email'], $request->userInfo['name']);  // Add a recipient
            $mail->AddEmbeddedImage('img/logo2x.png', 'logo_2u');
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "Gauto užsakymo patvirtinimas";

            $prekes='';
            foreach($request->cart as $preke ){
                $findProduct=Product::findorFail($preke['id']);
                $prekes.= '<tr>
                             <td>'.$preke['title'].'</td>'.
                    '<td>'.$preke['capacity'].'</td>'.
                    '<td>'.$preke['quantity'].'</td>'.
                    '<td>'.$findProduct['discount_price'].'</td>'.
                    '</tr>';
            }

            $temp=Shipping::findOrFail($request->userInfo['shipping']);
            $deliveryType= $temp['title'];
            if ($request->userInfo['shipping'] ==1){
                $deliveryTime='Dėl pristatymo laiko susisieksime';
            }else{
                $deliveryTime=$temp['days'];
            }
            $payment=$request->userInfo['paymentType'];
            $freeShippingPriceObject=Settings::findOrFail(1)->get();

            $freeShippingPrice=$freeShippingPriceObject[0]['value'];
            $shippingPrice=$temp['price'];
            if ($allProductsPrice>=$freeShippingPrice){
                $shippingPrice=0;
            }
            $finalTotal=$allProductsPrice+$shippingPrice;
            $mail->Body = " <html>
                             <head>
                                <style>
                                table, th, td {
                                  border: 1px solid black;
                                  border-collapse: collapse;
                                }
                                th, td {
                                  padding: 5px;
                                  text-align: left;    
                                }
                                </style>
                            </head>
                                <body>
                                    <p>AČIŪ, kad užsakėte produktus iš bityno Gintarinis medus!<br>
                                    Artimiausiu metu informuosime dėl Jūsų užsakymo pristatymo.<br><br>
                                    ***********************************************************</p>
                                    <h3>Užsakymo detalės</h3>
                                    <table style=\"width:50%\">
                                      <tr>
                                        <th>Užsakymo numeris</th>
                                        <th>Atsiskaitymo būdas</th>
                                        <th>Pristatymo būdas</th>
                                        <th>Numatomas pristatymas</th>
                                      </tr>
                                      <tr>
                                        <td>$orderId</td>
                                        <td>$payment</td>
                                        <td>$deliveryType</td>
                                        <td>$deliveryTime</td>
                                      </tr>
                                    </table>
                                    <div>
                                     <h3>Užsakymas</h3>
                                     <table style=\"width:50% \">
                                      <tr>
                                        <th>Prekė</th>
                                        <th>Svoris kg</th>
                                        <th>Kiekis vnt</th>
                                        <th>Kaina (vnt)</th>
                                      </tr>
                                      $prekes
                                    </table>
                                    <p>Viso už prekes: $allProductsPrice eur.<br>
                                    Už transportą: $shippingPrice eur.</p>
                                    <h3>Užsakymo suma: $finalTotal eur.</h3>
                                     <p>***********************************************************</p>
                                    </div>
                                <div>
                                    <h3>Mokėjimos infromacija<h3/>
                                    <p>Gavėjas: Martynas Kašelionis<br>
                                    Mokėjimo sąskaitos nr.: LT067300010144435761<br>
                                    Mokėjimo paskirtis: $orderId <br>
                                    Užsakymo suma VISO: $finalTotal eur </p>
                                </div> 
                                *********************************************************** 
                                <div>
                                    <h3>Turite klausimų?</h3>
                                    <p>El paštas: m.kaselionis@gmail.com <br>
                                    Telefonas +370 612 17830</p><br>
                                    <p>Apie tolesnį užsakymo vykdymą būsite informuotas el.paštu. <br>
                                    Dėkojame, kad perkate mūsų bityno produkciją. Linkime Jums sveikatos!</p>
                                </div>
                                </body>
                                <img src='cid:logo_2u' alt=\"logo\">
                           </html>";
            $mail->AltBody = $request->message;
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
