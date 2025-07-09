function widgetFileDraw(id, results) {
    let html = '';

    results.forEach(function (element) {
        // pasamos la URL en lugar del "match"
        html += '<tr class="clickableRow" onclick="widgetFileSelect(\'' + id + '\', \'' + element.filePath + '\');">'
                + '<td>' + element.fileName + '</td>'
                + '<td>' + element.fileType + '</td>'
                + '<td>' + new Date(element.uploadDate).toLocaleString() + '</td>'
                + '</tr>';
    });

    $("#list_" + id).html(html);
}

function widgetFileSearch(id) {
    $("#list_" + id).html("");

    let input = $("#" + id);
    let data = {
        action: 'widget-file-search',
        active_tab: input.closest('form').find('input[name="activetab"]').val(),
        col_name: input.attr("name"),
        query: $("#modal_" + id + "_q").val(),
        // puedes agregar más filtros si los tienes
    };

    $.ajax({
        method: "POST",
        url: window.location.href,
        data: data,
        dataType: "json",
        success: function (results) {
            widgetFileDraw(id, results);
        },
        error: function (msg) {
            alert(msg.status + " " + msg.responseText);
        }
    });
}

function widgetFileSearchKp(id, event) {
    if (event.key === "Enter") {
        event.preventDefault();
        widgetFileSearch(id);
    }
}

function widgetFileSelect(id, url) {
    window.location.href = url; // redirige a la URL en la misma pestaña
}

function deleteAttachedFile(fileId, widgetId) {
    if (!confirm("¿Estás seguro de que deseas eliminar este archivo?"))
        return;

    fetch('AjaxDeleteFileAttachment?action=delete&id=' + fileId, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error HTTP: ' + response.status);
        }
        return response.json();  // Convertimos la respuesta a JSON
    })
    .then(result => {
        if (result.success) {
            alert("Archivo eliminado correctamente.");
            location.reload();  // O actualiza solo la tabla si prefieres
        } else {
            alert("Error al eliminar archivo: " + result.message);
        }
    })
    .catch(error => {
        alert("Error en la petición: " + error.message);
    });
}



