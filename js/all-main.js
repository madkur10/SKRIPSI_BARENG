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

function exporttoexcel(datanya, judulnya) {
    var a = document.createElement('a');
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById(datanya);
    var table_html = table_div.outerHTML.replace(/ /g, '%20');
    a.href = data_type + ', ' + table_html;
    a.download = judulnya + '.xls';
    a.click();
    e.preventDefault();
}

function printData(id)
{
    var divToPrint = $("#"+id);
    var myStyle = '<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">';
    newWin= window.open("");
    newWin.document.write(myStyle + divToPrint.html());
    newWin.print();
    newWin.close();
}
function printDiv(id){        
    printData(id);
}

function checkNik(e) {
    var length = $(e).val().length
    if (length >= 10) {
        $.ajax({
            url: `action/ajaxData/validation.php?tipe=checknik`,
            type: `POST`,
            data: { nik :  $(e).val()},
            dataType: 'json',
            success: function (result) {
                if(result.metadata.code == 201){
                    $(`#check-nik`).html('<p><font color="red">*No Identitas Sudah Digunakan</font></p>')
                }else if (result.metadata.code == 200) {
                    $(`#check-nik`).html('<p><font color="green">No Identitas Valid</font></p>')
                }                                   
            },
            error: function (error, text, code) {
                $(`#check-nik`).html('<p><font color="green">No Identitas Valid</font></p>')
            }
        });
    }else{
        $(`#check-nik`).html('<p><font color="red">*Panjang karakter Minimal 10</font></p>')
    }
}

function checkPassword(e) {
    var password = $(`#password`).val()
    var repassword = $(`#re-password`).val()

    if (password === repassword) {
        $(`#check-pass`).html('<p><font color="green">Password Sudah Valid</font></p>')
    }else{
        $(`#check-pass`).html('<p><font color="red">Password Tidak Valid</font></p>')
    }
}