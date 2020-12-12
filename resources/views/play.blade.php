<!DOCTYPE html>
<html>
<head>
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <title>Scramble Word</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/game.css') }}">
</head>
  <center>
    <header>
        <ul>
        @if(Auth::user())
         <li><a class="links" href="{{route('logout')}}"><button class="signbutton" type="button">Sign Out</button></a></li>
          <li><a href="#images">{{  Auth::user()->name }}</a></li>
          <li><a href="#images">Point : <input type="text" id="score" value ="{{ Auth::user()->score }}" disabled></a></li>
          <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Rules:
          1. Guess the correct word from the random word that appears. 
          2. If your guess word is correct, you will get +1. 
          3. If your guess word is wrong, then the point will be -1."><i class="fa fa-exclamation-circle"></i></a></li>
        @endif
        </ul>  
    </header>
    @if(Auth::user())
    <div class="history">
        @foreach($histories as $history)
        <div class="card">
            <div class="card-body">{{ $history->answer }}@if($history->status) <i class="fa fa-check btn-success"></i> +1 @else  <i class="fa fa-close btn-danger"></i> - 1 @endif</div>
        </div>
        <br>
        @endforeach
   </div>
   @endif
   <div class="content">
   <input type="hidden" id="wordId">
        <div class="logo">
            <h1 class="ml1">
                <span class="text-wrapper">
                    <span class="line line1"></span>
                    <span class="letters" id="word">{{ (Auth::user()) ? : 'SCRAMBLE WORD' }}</span>
                    <span class="line line2"></span>
                </span>
            </h1>
        </div>
        @if(Auth::user())
            <div class="bar">
                <input class="searchbar" type="text" id="answer" title="Answer" style="text-transform:uppercase" required>
            </div>
        @endif
            <div class="buttons">
        @if(Auth::user())
            <button class="signbutton" id="checkBtn" type="button">Check</button>
            <button class="signbutton" id="passBtn" type="button">Pass</button>
        @else
            <button class="signbutton" type="button" data-toggle="modal" data-target="#login">Play</button>
        @endif
        </div>
   </div>
 
@if(!Auth::user())
        @include('component.login-modal')
        @include('component.register-modal')
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js" integrity="sha512-53CQcu9ciJDlqhK7UD8dZZ+TF2PFGZrOngEYM/8qucuQba+a+BXOIRsp9PoMNJI3ZeLMVNIxIfZLbG/CdHI5PA==" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
<script>
    // Wrap every letter in a span
let textWrapper = document.querySelector('.ml1 .letters');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml1 .letter',
    scale: [0.3,1],
    opacity: [0,1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 600,
    delay: (el, i) => 70 * (i+1)
  }).add({
    targets: '.ml1 .line',
    scaleX: [0,1],
    opacity: [0.5,1],
    easing: "easeOutExpo",
    duration: 700,
    offset: '-=875',
    delay: (el, i, l) => 80 * (l - i)
  }).add({
    targets: '.ml1',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });

  

  $(document).ready(function(){

      getQuestion();

    //check
    $("#checkBtn").click(function(){

        let wordId = $('#wordId').val();
        let answer = $('#answer').val();

        $.ajaxSetup({
          headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          }
      });

        $.ajax({
            type: "POST",
            url: "{{ route('game.question.verify') }}",
            dataType: "JSON",
            data:{questionId: wordId, answer: answer},
            success: function(response)
            {
                let score = $('#score').val();

                if(response.status === false){
                    swal('wrong','','error');
                    $('#score').val(--score);
                    $(".history").append(`<div class="card-body"> ${response.answer} <i class="fa fa-close btn-danger"></i> - 1</div>`);
                } else {

                    swal('correct','','success');
                    $('#score').val(++score);
                    getQuestion();
                    $('#answer').val('');
                    $(".history").append(`<div class="card-body"> ${response.answer} <i class="fa fa-check btn-success"></i> +1</div>`);
                }
            }

        })
        
    });

    $("#passBtn").click(function(){
        getQuestion();
    })

    $('#registerOnLogin').click(function(){
        $('#login').modal('hide');
        $('#register').modal('show');
    })

    $('#loginOnRegister').click(function(){
        $('#login').modal('show');
        $('#register').modal('hide');
    })

    //tooltip
    $('[data-toggle="tooltip"]').tooltip();
});

function getQuestion() {
    $.ajax({
      type: "GET",
      url: "{{ route('game.question') }}",
      success: function(response) {
        $('#wordId').val(response.id);
        $('#word').html(response.word);
      }
  })
}

</script>
  </body>