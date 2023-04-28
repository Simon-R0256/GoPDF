@extends ('layouts.layout')

@section('HeadContent')
<title>Editor</title>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

@endsection

@section('Navbar')
<!-- Navigation-->
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/documents">Dokumente</a>
</li>
<li class="nav-item transition activeLink mx-4">
    <a class="nav-link fs-4 p-0" href="/editor">Editor</a>
</li>
<li class="nav-item transition mx-4">
    <a class="nav-link fs-4 p-0" href="/help">Hilfe</a>
</li>

@if(Auth::User()->role == "Admin")
<li class="nav-item mx-4 dropdown">
    <a class="nav-link fs-4 p-0 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        Admin
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item transition" href="/admin"><i class="bi bi-people-fill me-2"></i>Nutzer-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api"><i class="bi bi-broadcast-pin me-2"></i>API-Verwaltung</a></li>
        <li><a class="dropdown-item transition" href="/admin/api/logs"><i class="bi bi-journals me-2"></i>API-Logs</a></li>
    </ul>
</li>
@endif

@endsection

@section('BodyContent')
<!--Erweitert das Layout um den Content der Section -->

<script>
tinymce.init({
    selector: 'textarea',

    promotion: false,
    branding: false,

    plugins: 'image pagebreak quickbars lists code wordcount table fullscreen',

    toolbar: 'undo redo | fontfamily fontsize | alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | fullscreen',

    language: 'de',

    skin: "CUSTOM",
    content_css: "CUSTOM",

    fullscreen_native: true,
    height: 550,
    resize: false,

    newline_behavior: 'invert',

});
</script>

<div class="row justify-content-center">
    <div class="col-10 mt-3 editorStyle">

        <form method="POST" action="/editor/save">
            @csrf

            <div class="row py-3 justify-content-center align-items-center">

                <!-- Editor Überschrift -->
                <div class="col-auto editorHead mt-2 ms-3 me-auto px-4">
                    <span style="font-size:40px" class="bi bi-file-earmark-code"></span>
                    <span style="float:right;font-size: 40px;font-weight: 400;font-family: Helvetica;">-Editor</span>
                </div>

                <!--Dokumenten-Name Textfeld -->
                <div class="col-auto mt-2">

                    <div style="display: flex;flex-wrap: nowrap;" class="input-group">
                        <span class="input-group-text nameIcon">
                            <span style="font-size:25px" class="bi bi-file-earmark-text me-2"></span>
                            <span style="font-size:22px">Name</span>
                            <span style="font-size:25px" class="bi bi-arrow-right ms-2"></span>
                        </span>
                        @isset($document)
                        <input class="editorNameField" type="text" name="document_name"
                            value="{{$document->document_name}}" required>
                        @else
                        <input class="editorNameField" type="text" name="document_name" required>
                        @endif
                    </div>
                </div>

                <!--Speichern Button  -->
                <div class="col-auto mt-2 me-2">
                    <button type="submit" class="btn editorButton">Speichern 
                        <span class="bi bi-file-earmark-check"></span>
                    </button>
                    @isset($document_data)
                    <input style="display:none" type="number" name="id" value="{{$document->id}}">
                    @endisset
                </div>

            </div>

            <!-- TinyMCE Editor -->
            <div class="row pb-3">
                <div class="col">
                    @isset($document_data)
                    <textarea name="documentContent_update">
                            {{$document_data}}
                        </textarea>
                    @else
                    <textarea name="documentContent"></textarea>
                    @endif
                </div>
            </div>

        </form>

    </div>
</div>


@endsection