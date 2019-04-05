document.addEventListener('DOMContentLoaded', function(){

    /*-- AUTO CLICK EN btn_confirmar, SI NO RESPONDE EN 60 SEGUNDOS --*/
     var t; //tiempo

     function logout() {
      //  window.location.href = 'http://localhost/OOP+SQL/corner/public/login.php';  //Adapt to actual logout script
     }

     function reload() {
       window.location = self.location.href;  //Reloads the current page
     }

     function resetTimer() {
       //console.log(t);
        clearTimeout(t);
      //  t= setTimeout(logout, 70000000000000);  // time is in milliseconds (1000 is 1 second)
        t= setTimeout(reload, 300000);  // time is in milliseconds (1000 is 1 second) 5min
     }

    //window.onload = resetTimer;
    window.onmousemove = resetTimer; // catches mouse movements
    window.onmousedown = resetTimer; // catches mouse movements
    window.onclick = resetTimer;     // catches mouse clicks
    window.onscroll = resetTimer;    // catches scrolling
    window.onkeypress = resetTimer;  //catches keyboard actions



     resetTimer();// para q empiece a contar t




 });//DOM content load
