document.addEventListener('DOMContentLoaded', function() {
   const form = document.getElementById('form')
   var btn = document.getElementById('btn')

   btn.onclick = formSend;

   async function formSend() {

      let error = formValidate()
      let formData = new FormData(form)

      if(error == 0) {
         fetch('../../ajax.php', {
            method: 'POST',
            body: formData
         }).then(response => response.json())
         .then((json) => {
            if(json['status'] == "ok") {
               alert('fwfwefewf wfewfew')
               
            }
         })
      }
      else {
         alert('Заполните поля корректно!')
      }
   }

   function formValidate() {
      let error = 0
      let formReq = document.querySelectorAll('._req');

      const input = formReq[0]
      formRemoveError(input)

      if(input.classList.contains('_address')) {
         if(addressTest(input)) {
            formAddError(input)
            error++
         }
      }
      else {
         if(input.value === '') {
            formAddError(input)
            error++
         }
      }

      return error
   }

   function formAddError(input) {
      input.parentElement.classList.add('error')
      input.classList.add('error')
   }

   function formRemoveError(input) {
      input.parentElement.classList.remove('error')
      input.classList.remove('error')
   }

   function addressTest(input) {
      return !/^[0-9a-zA-Z]+$/.test(input.value);
   }
})