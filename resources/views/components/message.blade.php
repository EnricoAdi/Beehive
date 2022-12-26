@php
    $message = "";
    $status_class = "";
    $path_stroke = "";
    $nofill = false;
    if(session()->has("success")){
        $message = session()->get("success");
        $status_class = "success";
        $path_stroke = "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z";
    }
    if(session()->has("error")){
        $message = session()->get("error");
        $status_class = "error";
        $path_stroke = "M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z";
    }
    if(session()->has("warning")){
        $message = session()->get("warning");
        $status_class = "warning";
        $path_stroke = "M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z";
    }
    if(session()->has("info")){
        $message = session()->get("info");
        $status_class = "info";
        $path_stroke = "M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z";
    }
@endphp

@if ($status_class!="")
<div class="alert alert-{{$status_class}} shadow-lg w-96 sticky ml-auto bottom-4 mr-4" id="msg1">
    <div>
      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{$path_stroke}}" /></svg>
      <div class="break-words">{{$message}}</div>
    </div>
    <div class="flex-none">
      <button class="btn btn-sm bg-opacity-0 border-0 text-xl fa-regular fa-circle-xmark text-red-500" id="close-message">
      </button>
    </div>
</div>

<script type="text/javascript">
    setTimeout(() => {
        document.getElementById("msg1").style.visibility = "hidden";
    }, 8000);
    document.getElementById("close-message").onclick = function(){
        document.getElementById("msg1").style.visibility = "hidden";
    }
</script>
@endif

{{-- @if ($errors->any())
<div class="alert alert-error shadow-lg w-96 fixed right-2 bottom-8" id="msg1">
    <div>
    <span>
          @foreach ($errors->all() as $e)
            <li>{{ $e }} </li>
          @endforeach
    </span>
    <div class="flex-none">
      <button class="btn btn-sm bg-opacity-0 border-0 text-xl fa-regular fa-circle-xmark text-red-500" id="close-message">
      </button>
    </div>
    </div>
</div>

<script type="text/javascript">
    setTimeout(() => {
        document.getElementById("msg1").style.visibility = "hidden";
    }, 8000);
    document.getElementById("close-message").onclick = function(){
        document.getElementById("msg1").style.visibility = "hidden";
    }
</script>
@endif --}}

@if($nofill)
{{-- ini biarin aja, buat init ke tailwindnya kalau kita pakai ini --}}
<div class="alert-info alert-warning alert-success alert-error"></div>
@endif
