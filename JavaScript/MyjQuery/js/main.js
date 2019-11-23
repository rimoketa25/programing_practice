'use strict';

$(function () {
  // セレクタ：処理対象となるDOM要素を指定する記法。$("")の中に書く
  // 単独要素
  $('h4').css('color', 'red'); // html要素 p h1 ul
  $("#main").css('color', 'blue'); // id #main
  $(".item").css('color', 'green'); // class .item
  // 複数要素
  $("#sub > li").css('font-size', '10px'); // 直下の子要素 >
  $("#main .item").css('font-size', '20px'); // それ以下の要素 空白
  $("#sub, .item").css('background', 'orange'); // 複数の要素 ,
  $(".item + .item").css('color', 'pink'); // 隣接する要素 + 

  // フィルタ
  //  :eq()
  $("#filter > li:eq(2)").css('color', 'red');
  //  :gt(), :lt()
  $("#filter > li:gt(5)").css('color', 'pink');
  //  :even, :odd
  $("#filter > li:odd").css('color', 'blue');
  //  :contains()
  $("#filter > li:contains(5)").css('color', 'skyblue');
  //  :first, :last
  $("#filter > li:first").css('color', 'orange');

  // メソッドを使ったDOM要素の指定
  //  parent(), children() - 指定した要素の親・子要素
  $("#filter").children().css('font-size', '12px');
  //  next(), prev() - 指定した要素の次・前要素
  $("#next").next().css('font-size', '17px');
  //  siblings() - 指定した要素と同列の兄弟要素
  $("#siblings").siblings().css('background', '#ccc');

  // 属性セレクタ
  //  =  - 等しい
  $('#1-3 a[href="http://google.com"]').css('color', 'red');
  //  != - 等しくない
  $('#1-3 a[href!="http://google.com"]').css('color', 'white');
  //  *= - 含む
  $('#1-3 a[href*="dotinstall"]').css('background', 'red');
  //  ^= - 前方一致
  //  $= - 後方一致
  $('#1-3 a[href$="jp"]').css('background', 'gray');

  // .css 設定 取得
  $('#1 p').css('color', 'green');
  $('#c-color').click(function () {
    alert($('#1 p').css('color'));
  });

  // addClass removeClass
  $('#add').click(function () {
    $('#sample').addClass('myStyle');
  });
  $('#remove').click(function () {
    $('#sample').removeClass('myStyle');
  });

  // attr：HTMLの属性の操作
  $('#3 a').attr('href', 'http://google.co.jp');
  $('#c-href').click(function () {
    alert($('#3 a').attr('href'));
  });
  // data：HTMLのカスタム属性の操作
  $('#c-data').click(function () {
    alert($('#3 a').data('sitename'));
  });

  // text
  $('#c-text').click(function () {
    $('#change1').text('just changed');
  });

  // html
  $('#c-html').click(function () {
    $('#change2').html('<a href="">click me!</a>');
  });

  // val
  $('#c-val').click(function () {
    $('#change3').val('hello, again!');
  });

  // empty
  $('#empty').click(function () {
    $('#change4').empty();
  });

  // remove
  $('#remove1').click(function () {
    $('#change5').remove();
  });

  // before, after -> inserBefore, insertAfter
  var li = $('<li>').text('just added');
  //$('ul > li:eq(1)').before(li);
  // li.insertBefore($('ul > li:eq(1)'));

  // prepend, append -> prependTo, appendTo
  //$('ul').append(li);
  li.appendTo($('ul'));

  // hide, show
  // fadeOut, fadeIn
  // toggle
  //$('#box').hide(800);
  //$('#box').fadeOut(800);
  //$('#box').toggle(800);
  $('#box').fadeOut(800, function () {
    //alert("gone!");
  });

  // click
  // mouseover, mouseout, mousemove
  $('#box').click(function () {
    alert("hi!");
  });
  $('#box')
    .mouseover(function () {
      $(this).css('background', 'green');
    })
    .mouseout(function () {
      $(this).css('background', 'red');
    })
    .mousemove(function (e) {
      $(this).text(e.pageX);
    });

  // focus, blur
  // change
  $('#name')
    .focus(function () {
      $(this).css('background', 'red');
    })
    .blur(function () {
      $(this).css('background', 'white');
    });
  $('#members').change(function () {
    alert('changed!');
  });

  // 
  // $('button').click(function () {
  //   var p = $('<p>').text('vanish!').addClass('vanish');
  //   $(this).before(p);
  // });

  /*
  $('.vanish').click(function() {
      $(this).remove();
  });
  */

  $('body').on('click', '.vanish', function () {
    $(this).remove();
  });

  // Ajax
  // Asynchronous JavaScript + XML
  // ページ内でサーバーと非同期通信 + ページの書き換え
  // ＊非同期: 処理が終わる前に次の処理に移る

  // $('button').click(function () {
  //   $('#result').load('more.html', function () {
  //     $('#message').css('color', 'red');
  //   });
  // });

  $('#greet').click(function () {
    $.get('greet.php', {
      name: $('#name').val()
    }, function (data) {
      $('#result').html(data.message + '(' + data.length + ')');
    });
  });
});