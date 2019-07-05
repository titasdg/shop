<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Pavadinimas' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($page->title) ? $page->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<label for="title" class="control-label">{{ 'Puslapis' }}</label>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
                @if($formMode === 'edit')
                        <textarea id="ckview" class="form-control mb-20 editor" name="content" rows="10" cols="50">{{$page->content}}</textarea>
                 @else
                 <textarea id="ckview" class="form-control mb-20 editor" name="content" rows="10" cols="50"></textarea>
                 @endif
                      <script>
                      //var ckview = document.getElementById("ckview");

                  setTimeout(function(){
                      CKEDITOR.replace('ckview',{
                              filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                              filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                              filebrowserWindowWidth: '1000',
                              filebrowserWindowHeight: '700',
                              language:'en-gb'
                                      
                                          });
                  },100);
                      </script>         

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Redaguoti' : 'Kurti' }}">
</div>
