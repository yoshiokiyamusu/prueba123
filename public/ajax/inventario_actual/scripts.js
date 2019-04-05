document.addEventListener('DOMContentLoaded', function(){

    const input_ajuste = document.querySelector('input[name="ajuste_qty"]');
    input_ajuste.addEventListener("input",checklettersymbol);

    function checklettersymbol(){ //overwrite with 0 if user enter any symbol or letter
      var inputVal = this.value;
      if (inputVal.match(/[a-z]/i)) {
        this.value = 0;
      }else if(inputVal.match(/[-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/)){
        this.value = 0;
      }
    };

});//DOM content load
