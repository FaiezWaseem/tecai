var drop  =  `<div class="item dragdrop" sid="world">world</div>`; var drag  = `what a <div class="drop" target="world"></div> we live in ?`; var bg  = `Background_fill_in_the_blanks.svg`; var theme  = `1`;
      document.querySelector(".paragraphcontainer").innerHTML = drag;
      document.querySelector(".selection").innerHTML = drop;
      document.body.style.backgroundImage = `url("${bg}")`;
      