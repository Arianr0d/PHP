var time = 10; //5400;
//localStorage.setItem('currenttime', 10);

//counts()
//setInterval(counts, 1000);

export let counts = () => {
    let hours = Math.floor(time / 60 / 60);
    let minutes = Math.floor(time / 60) % 60;
    let seconds = time  % 60;

    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

   console.log(time)

    if(time <= 0) {
       time = 10;
       //window.location.href = '../index.html'
       document.getElementById('start_form').hidden = false;
       document.getElementById('second_form').hidden = true;
    }

    document.getElementById('h').innerText = hours + ':';
    document.getElementById('m').innerText = minutes + ':';
    document.getElementById('s').innerText = seconds;
    localStorage["currenttime"] = time;

    time--;
}