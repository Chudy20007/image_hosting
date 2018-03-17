@extends('main') @section('content') @php ($a=0)

<?php if($a/3==0 || $a==0) echo "<div class='row rowPictures'>"; ?>
<div class='col-md-3 col-sm-3 picture'>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            {{$user}}
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12'>
            <a href="">
                <img class='img-fluid img-thumbnail' src=''>
            </a>
        </div>
    </div>


    <div class='row'>
        <div class='col-md-12 col-sm-12'>
            <span> </span>
        </div>
        <br/>


    </div>
    <div class="card-footer author">
        Added by:
        <b></b>
        <div class='div-comments'>
            <a href="#">
                <img style="margin-left:5px" src="../resources/img/speech-message.png" placeholder="comments" />
                <span class='image-comments'>32 comments</span>
            </a>
        </div>
    </div>
</div>
@php($a++)
<?php if($a/3==0) echo "</div>";?> @stop