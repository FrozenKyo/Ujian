jQuery(function($) {
    
    $('#data-row').on('click', 'a.delete-row',function(event){
        event.preventDefault();
        var $booktable = $(this);
        var remove_id = $(this).attr('id');
        remove_id = remove_id.replace("remove-","");

        $.post("buku/index", {
            id: remove_id
        },
        function(data){
            if(data.response == true)
                $booktable.parent().remove();
                //parent.window.location.reload(true);
            else{
                // print error message
                alert('could not remove');
                console.log('could not remove ');
            }
        }, 'json');
    });
});