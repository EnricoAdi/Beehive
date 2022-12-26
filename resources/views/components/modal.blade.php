@php
    $modalOpen = false;
    $message = "";
    if(session()->has("open-modal")){
        $modalOpen = true;
        $message = session()->get("open-modal");
    }
@endphp

@if ($modalOpen)
<input type="checkbox" id="modal" class="modal-toggle" />
<div class="modal modal-bottom sm:modal-middle">
<div class="modal-box">
    <h3 class="font-bold text-lg">Beehive</h3>
    <p class="py-4">{{$message}}</p>
    <div class="modal-action">
    <label for="modal" class="btn">OK</label>
    </div>
</div>
</div>

<script type="text/javascript">
    document.getElementById('modal').checked = true;
</script>

@endif
