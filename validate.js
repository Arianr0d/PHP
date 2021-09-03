document.addEventListener('DOMContentLoaded', function() {
   const form = document.getElementById('start_form');
   var btn1 = document.getElementById('btn1');
   //form.addEventListener('submit', formSend);
   //addEventListener('submit', formSend);

   const form2 = document.getElementById('second_form');
   var btn2 = document.getElementById('btn2');
   //form2.addEventListener('submit', formSend2);
   //addEventListener('submit', formSend2)

   btn1.onclick = formSend;
   btn2.onclick = formSend2;

   async function formSend() {
      let error = formValidate(form);
      
      let formData = new FormData(form);

      console.log(error)
      if(error === 0) {
         fetch('/vendor/signup.php', {
            method: 'POST',
            body: formData
         }).then(response => response.json())
         .then((json) => {
            if(json['status'] == "ok") {
               console.log(json['result'])
               alert(json['result']['res'])
               //form.reset();
            }
         });
      } 
      else {
         alert('Заполните поля корректно!')
      }
   }

   async function formSend2() {
      let error = formValidate2(form2);

      let formData = new FormData(form2);

      if(error === 0) {
         fetch('/vendor/signup.php', {
            method: 'POST',
            body: formData
         }).then(response => response.json())
         .then((json) => {
            console.log(json['result'])
            alert(json['result']['res'])
            //form2.reset();
         });
      } 
      else {
         alert('Заполните поля корректно!')
      }
   }

   function formValidate(form) {
      let error = 0;
      let formReq = document.querySelectorAll('._req1');

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

   function formValidate2(form) {
      let error = 0;
      let formReq = document.querySelectorAll('._req2');

      for(let index = 0; index < formReq.length; index++) {
         const input = formReq[index]
         formRemoveError(input)

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

   //функция проверки логина
   function loginTest(input) {
      return !/^[a-zA-Z1-9_]+$/.test(input.value);
   }

   //функция проверки пароля
   function password(input) {
      return !/^[0-9a-zA-Z!@#$%^&*]+$/.test(input.value);
   }
})