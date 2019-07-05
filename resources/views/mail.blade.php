

<body>
    <form action="/send" method="post">
        @csrf

        <input type="text" title="from" name="from">
        <input type="text" title="subject" name="subject">
        <input type="text" title="message" name="message">

        <input type="submit">
    </form>

</body>

