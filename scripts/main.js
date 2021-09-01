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
document.getElementsByClassName('btn')[0].onclick = function (e) {
    e.preventDefault();

    if(reg_name.test(inp_text[0].value) && reg_name.test(inp_text[1].value) && reg_name.test(inp_text[2].value) &&
        reg_email.test(inp_text[3].value) && reg_phone.test(inp_text[4].value) && reg_comment.test(inp_text[5].value)) {

        //document.getElementsByClassName('form')[0].classList.add('_sending');

        // отправка формы методом POST в 'sendmail'     
        let formData = new FormData(document.getElementById("start_form"));
        let response = fetch('sendmail.php', {
            method: 'POST',
            body: formData
        });

        // проверка отправки формы
        if(response.ok) {
            let result = response.json();
            alert(result.message);
            inp_text.reset();
            window.location.href = "/formsend.html"
        }
        else {
            alert('Произошла ошибка');
        }
    } else {
        for(let i=0; i < inp_text.length; i++) {
            Check(inp_text[i]);
        }
        alert('Форма не отправлена! \nПожалуйста, проверьте введённые данные!');
    }
};