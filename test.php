<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<body>

<input id="menuopen-input" type="checkbox">
<nav id="menu-nav">
   <ul>
      <li><span><b>メニュー</b></span><span><label for="menuopen-input"><b>×</b></label></span></li>
      <li><a href="#">ABOUT</a></li>
      <li><a href="#">CONTENT</a></li>
   </ul>
</nav>
<div id="main-container">
   <div class="main-header">
   <label for="menuopen-input"><i class="material-icons">person</i></label>
   </div>
   <h2>content</h2>
</div>

<style type="text/css">
#menuopen-input{
 display: none;
}
#menuopen-input:checked ~ #menu-nav{ left: 0; }
#menuopen-input:checked ~ #main-container{ left: 240px; }

#menu-nav{
 position: fixed;
 height: 100%;
 width: 240px;
 top: 0;
 left: -240px;
 background: #123490;
 color: #ffffff;
 z-index: 1000000000;
 transition: left 0.1s linear;
 -webkit-transition: left 0.1s linear;
}
#menu-nav li{
 list-style: none;
 height: 48px;
 line-height: 48px;
 padding-left: 24px;
}
#menu-nav li a{
 color: #ffffff;
}

#menu-nav li:nth-child(1) span:nth-child(2){
 padding-left: 120px;
 font-size: 18px;
 cursor: pointer;
}
#menu-nav li:nth-child(1) span label{
 cursor: pointer;
}


#main-container{
 position: relative;
 left: 0;
 width: 100%;
 height: 100%;
 box-sizing: border-box;
 z-index: 1;
 transition: left 0.1s linear;
 -webkit-transition: left 0.1s linear;
}
/*---  menu icon ---*/
@font-face{
 font-family: 'fontello';
 src: url('font/fontello.eot');
 src: url('font/fontello.eot#iefix') format('embedded-opentype'),
      url('font/fontello.woff') format('woff'),
      url('font/fontello.ttf') format('truetype'),
      url('font/fontello.svg#fontello') format('svg');
 font-weight: normal;
 font-style: normal;
}
.menu-icon{
 font-family: "fontello";
 font-style: normal;
 font-weight: normal;
 font-size: 32px;
 display: inline-block;
 text-decoration: inherit;
 cursor: pointer;
 color: #ffffff;
 margin: 4px 4px;
}
</style>
</body>
