document.addEventListener('DOMContentLoaded', function(){

    //para view de view-receiving/ordenes.php -------//
    var btn_change_recdate = document.querySelectorAll('.btn_change_receiving_date');
    Array.from(btn_change_recdate).forEach(
      function(btn_change_recdate){
         btn_change_recdate.addEventListener("click",  update_receiving_date);
      }
    );

    function update_receiving_date() {
       var target = this.parentElement.children[0];                        //console.log(target);
       var $nueva_fecha = this.parentElement.children[0].value;            // console.log(nueva_fecha);
       var $os_rowid = this.parentElement.parentElement.children[0].children[0].value; //console.log(os_rowid);
       var url = '../ajax/receiving/update_recep_fecha.php?os_rowid=' + $os_rowid + '&fecha=' + $nueva_fecha;

           //crear objeto XMLHttpRequest
           var xhr = new XMLHttpRequest();
           xhr.open('GET', url, true);
           xhr.onreadystatechange = function () {
             if(xhr.readyState == 2) {

             }
             if(xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
             }
           }
           xhr.send();

    }//END update_receiving_date()


});//DOM content load
