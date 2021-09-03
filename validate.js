document.addEventListener('DOMContentLoaded', function() {
   const form = document.getElementById('start_form');
   form.addEventListener('submit', formSend);

   async function formSend(e) {
      e.preventDefault()

      let error = formValidate(form);
      
      let formData = new FormData(form);

      console.log(error)
      if(error === 0) {
         fetch('/vendor/signup.php', {
            method: 'POST',
            body: formData
         }).then(response => response.json())
         .then((json) => {
            form.reset();
            console.log(json['status'])
         });
      } 
      else {
         alert('Заполните поля корректно!')
      }
   }

   function formValidate(form) {
      let error = 0;
      let formReq = document.querySelectorAll('._req');

      for(let index = 0; index < formReq.length; index++) {
         const input = formReq[index]
         formRemoveError(input)

         if(input.classList.contains('_login')) {
            if(loginTest(input)) {
               formAddError(input)
               error++
            }
         }
         else if(input.classList.contains('_password')) {
            if(password(input)) {
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
      }

      return error
   }

   function formAddError(input) {
      input.parentElement.classList.add('_error')
      input.classList.add('error')
   }

   function formRemoveError(input) {
      input.parentElement.classList.remove('_error')
      input.classList.remove('error')
   }

   //функция проверки логина
   function loginTest(input) {
      return !/^[a-zA-Z1-9_]+$/.test(input.value);
   }

   //функция проверки пароля
   function password(input) {
      return !/^[0-9a-zA-Z!@#$%^&*]*$/.test(input.value);
   }
})