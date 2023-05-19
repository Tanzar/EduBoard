/**
 * Simple dialog controls
 */

export function DialogBox(id){
    if(typeof id !== 'string'){
        throw new Error(`Id  must be type of string, ${typeof id} given.`)
    }

    var dialogId = id;

    if (document.getElementById(dialogId + '-close')) {
        document.getElementById(dialogId + '-close').onclick = function(){
            document.getElementById(dialogId).close();
        }
    }

    document.body.addEventListener('keypress', function(e) {
        if (e.key == "Escape") {
            document.getElementById(dialogId).close();
        }
    });

    this.open = function(){
        document.getElementById(dialogId).showModal();
    }

    this.close = function() {
        document.getElementById(dialogId).close();
    }
}