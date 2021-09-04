document.addEventListener('DOMContentLoaded', function() {
   const form = document.getElementById('form')
   var btn = document.getElementById('btn')

   btn.onclick = formSend;

   async function formSend() {

      let error = formValidate()
      let formData = new FormData(form)

      if(error == 0) {
         fetch('../../vendor/ajax.php', {
            method: 'POST',
            body: formData
         }).then(response => response.json())
         .then((json) => {
            if(json['message'] == 'ok') {

               document.getElementById('info_metro').hidden = false
               
               document.getElementById('adress').innerText = json['address']
               document.getElementById('coord').innerText = json['coordinat']
               document.getElementById('nrst_metro').innerText = json['metroAddress']
            }
            else {
               alert(json['message'])
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

      if(input.value === '') {
         formAddError(input)
         error++
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
})