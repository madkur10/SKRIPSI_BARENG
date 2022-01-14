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
                        text: "Okey",
                    },
                }).then(function() {
                	if(result.metadata.redirect !== undefined){
                		window.location = result.metadata.redirect;
                	}
                });
            }else{
                notification(result.metadata.message,result.metadata.keterangan, 'error');
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
                    title: `${result.metadata.message}`,
                    text: `${result.metadata.keterangan}`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Okey",
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
    swal(`${tittle}`, text, type);
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
                    title: `${result.metadata.message}`,
                    text: `${result.metadata.keterangan}`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Okey",
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

function update_data(e){
    $.ajax({
        url: $('#updateData'+e).attr(`action`),
        type: $('#updateData'+e).attr(`method`),
        dataType: 'json',
        data: $('#updateData'+e).serialize(),
        success: function (result) {
            if(result.metadata.code == 200){
                swal({
                    title: `${result.metadata.message}`,
                    text: `${result.metadata.keterangan}`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Okey",
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

function delete_data(urlnya){
    $.ajax({
        url: urlnya,
        type: 'GET',
        dataType: 'json',
        success: function (result) {
            if(result.metadata.code == 200){
                swal({
                    title: `${result.metadata.message}`,
                    text: `${result.metadata.keterangan}`,
                    type: "success",
                    icon: "success",
                    button: {
                        text: "Okey",
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

function getDokter(e) {
    let klinikId = $(e).val();
    $.ajax({
        url: `action/ajaxData/getDokter.php?klinik_id=`+klinikId,
        type: `GET`,
        dataType: 'json',
        success: function (result) {
            $(`select[name=dokter_id]`).html(`<option value="" selected>--- Pilih Dokter ---</option>`);

            if(result.metadata.code == 200){
                $.each(result.response, function(i, item) {
                    $(`select[name=dokter_id]`).append(`<option value='${item.id}'>${item.nama_dokter}</option>`);
                });  
            }                                    
        },
        error: function (error, text, code) {

        }
    });
}

