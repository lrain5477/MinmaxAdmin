<?php
/**
 * @var \Illuminate\Support\MessageBag $errors
 */
?>
@if($errors->count() > 0)
<div class="alert alert-danger fade show" role="alert">
    <span class="text">{{ $errors->first() }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session()->has('success'))
<div class="alert alert-success fade show" role="alert">
    <span class="text">{{ session('success') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif