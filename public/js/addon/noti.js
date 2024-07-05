function Noti () {
}

(function () {
    function onInitializeNoti() {
        // insert into container
        var notiList = document.querySelectorAll('.noti');

        if(notiList.length > 0) {
            var notiContainerDiv = document.createElement('div');
            notiContainerDiv.classList.add('container');
            notiContainerDiv.classList.add('noti');

            notiList.forEach(function (noti) {
                notiContainerDiv.appendChild(noti);
            })

            document.body.appendChild(notiContainerDiv);
        }

    }

    document.addEventListener('DOMContentLoaded', onInitializeNoti);
})();



// Noti.prototype.queue = function (title, content) {
//     var div = document.createElement('div');
//     div.classList.add('noti');
//
//     var titleDiv = document.createElement('div');
//     titleDiv.classList.add('title');
//     titleDiv.innerText = title;
//     div.appendChild(titleDiv);
//
//     var contentDiv = document.createElement('div');
//     contentDiv.classList.add('content');
//     contentDiv.innerText = content;
//     div.appendChild(contentDiv);
//
//     document.body.appendChild(div);
// };

export default Noti;