$(".submit").on('click', function(){
    $.ajax({
        url: $(this).closest('form').attr(`action`),
        type: $(this).closest('form').attr(`method`),
        dataType: 'json',
        data: $(this).closest('form').serialize(),
        success: function (result) {
            if(result.metadata.code == 200){
                swal({
                    title: `${result.metadata.message}`,
                    text: `${result.metadata.keterangan}`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Login",
                    },
                }).then(function() {
                	if(result.metadata.redirect !== undefined){
                		window.location = result.metadata.redirect;
                	}
                });
            }else{
                notification(result.metadata.code,result.metadata.message, 'error');
            }
        },
        error: function (error, text, code) {
            notification(error.status,error.statusText, 'error');
        }
    });
});

function submitWithFunction(e){
    $.ajax({
        url: $(e).closest('form').attr(`action`),
        type: $(e).closest('form').attr(`method`),
        dataType: 'json',
        data: $(e).closest('form').serialize(),
        success: function (result) {
            if(result.metadata.code == 200){
                swal({
                    title: result.metadata.code,
                    text: `${result.metadata.code} - OK`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Login",
                    },
                }).then(function() {
                    if(result.metadata.redirect !== undefined){
                        window.location = result.metadata.redirect;
                    }
                });
            }else{
                notification(result.metadata.code,result.metadata.message, 'error');
            }
        },
        error: function (error, text, code) {
            notification(error.status,error.statusText, 'error');
        }
    });
}

function notification (tittle, text, type){
    swal(`Error Code : ${tittle}`, text, type);
}

$(".submitWithFile").on('click', function(){
	var form = $("#formUpload").closest("form");
	var formData = new FormData(form[0]);
	$.ajax({
	    data: formData,
	    dataType: "json",
	    url: $(this).closest('form').attr(`action`),
	    type: $(this).closest('form').attr(`method`),
	    processData: false,
	    contentType: false,
	    success: function(result) {
	         if(result.metadata.code == 200){
                swal({
                    title: result.metadata.code,
                    text: `${result.metadata.code} - Mohon Lakukan Login.`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Login",
                    },
                }).then(function() {
                	if(result.metadata.redirect !== undefined){
                		window.location = result.metadata.redirect;
                	}
                });
            }else{
                notification(result.metadata.code,result.metadata.message, 'error');
            }
	    },
	    error: function (error, text, code) {
            notification(error.status,error.statusText, 'error');
        }
	}) 

});