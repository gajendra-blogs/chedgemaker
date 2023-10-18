function showLoading() {
    document.querySelector('#loading').classList.add('loading');
    document.querySelector('#loading-content').classList.add('loading-content');
}

function hideLoading() {
    document.querySelector('#loading').classList.remove('loading');
    document.querySelector('#loading-content').classList.remove('loading-content');
}


function createErrorMeesage(msg , targetedElement , key)
{
    var message = `<span id="${key}-error" class="error invalid-feedback" style="display: block;">${msg}</span>`;
    targetedElement.after(message);
    $(targetedElement).addClass('is-invalid');
}

function createSuccessNotification(msg){
    var messageNotifucation =  `<div class="alert alert-success alert-notification"><i class="fa fa-check"></i> ${ msg }</div>`
    $('#notification-logging').append(messageNotifucation);
    setTimeout(function(){
     $('div.alert').fadeOut('slow' , 'swing')
    }, 3000);
 }