import {counts} from './timer.js'

const form = document.getElementById('start_form');
form.addEventListener('submit', formSend);

// регулярные выражения для проверки почты, номера телефона, ФИО и комментария
let reg_phone = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
let reg_email = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9-]+.+.[A-Za-z]{2,4}$/;
let reg_comment = /^.|\n{1,}$/;
let reg_name = /^[A-Za-zА-Яа-яЁё]{1,}$/;

// селекторы колекций
let inp_text = document.getElementsByClassName('inp_form');

// Функция валидации полей формы
for(let i=0; i < inp_text.length; i++) {
    inp_text[i].onblur = function() {
        let value = this.value;
        let rule = this.dataset.rule;
        let check;

        switch (rule) {
            case 'name':
                check = reg_name.test(value);
                break;
            case 'email':
                check = reg_email.test(value);
                break;
            case 'number_phone':
                check = reg_phone.test(value);
                break;
            case 'comment':
                check = reg_comment.test(value);
                break;
        }

        if (check) {
            this.classList.remove('error');
        } else {
            this.classList.add('error');
        }
    }
}

//-------------------------------------------------
function Check(inp) {
    let value = inp.value;
    let rule = inp.dataset.rule;
    let check;

    switch (rule) {
        case 'name':
            check = reg_name.test(value);
            break;
        case 'email':
            check = reg_email.test(value);
            break;
        case 'number_phone':
            check = reg_phone.test(value);
            break;
        case 'comment':
            check = reg_comment.test(value);
            break;
    }

    if (check) {
        inp.classList.remove('error');
    } else {
        inp.classList.add('error');
    }
}

// отправка формы при клике на кнопку "отправить"
async function formSend(e) {
   e.preventDefault();

   if(reg_name.test(inp_text[0].value) && reg_name.test(inp_text[1].value) && reg_name.test(inp_text[2].value) &&
        reg_email.test(inp_text[3].value) && reg_phone.test(inp_text[4].value) && reg_comment.test(inp_text[5].value)) 
   {
        console.log('asasdad')
        // отправка формы методом POST в 'sendmail'     
        let formData = new FormData(form);

         fetch('../sendmail.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then((json) => {

            console.log('wfewfewfwe')
            document.getElementById('start_form').hidden = true;
            document.getElementById('second_form').hidden = false;

            document.getElementById('name').innerText = json['name'];
            document.getElementById('surname').innerText = json['surname'];
            document.getElementById('middleName').innerText = json['middleName'];
            document.getElementById('email').innerText = json['email'];
            document.getElementById('numberPhone').innerText = json['numberPhone'];
            document.getElementById('comment').innerText = json['comment'];

            counts();
            setInterval(counts, 1000);

            form.reset();
         })
   } 
   else {
      for(let i=0; i < inp_text.length; i++) {
         Check(inp_text[i]);
      }
      alert('Форма не отправлена! \nПожалуйста, проверьте введённые данные!');
   }
}