function Noti () {
}

Noti.prototype.queue = function (title, content) {
    var div = document.createElement('div');
    div.classList.add('noti');

    var titleDiv = document.createElement('div');
    titleDiv.classList.add('title');
    titleDiv.innerText = title;
    div.appendChild(titleDiv);

    var contentDiv = document.createElement('div');
    contentDiv.classList.add('content');
    contentDiv.innerText = content;
    div.appendChild(contentDiv);

    var lastNotiList = document.querySelectorAll('.noti');
    if(lastNotiList.length > 0){
        div.classList.add('none');
    }

    div.onanimationend = function (e) {

        setTimeout(function () {
            var lastNotiList = document.querySelectorAll('.noti');

            if(lastNotiList.length > 1){
                lastNotiList[1].classList.remove('none');
            }

            e.target.remove();
        }, 3000);

    }

    document.body.appendChild(div);
}