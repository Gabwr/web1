var fecha_a=new Date();
$(document).ready(function(){
	let mi_tabla= $("#tabla").DataTable({
			ordering: false,
            dom: "Blp",
            buttons: [
                {
                    extend: "pdfHtml5",
                    text: "Exportar a PDF<i class='bi bi-file-earmark-pdf'></i>",
					className: "btn btn-danger",
                    title: "Reporte de Gastos", // 🔹 Cambia el título
                    customize: function(doc) {
                        // 🔹 Agregar encabezado personalizado
                        doc.content.unshift({
                            text: "Finanzas Familiares",
                            fontSize: 16,
                            alignment: "center",
                            bold: true,
                            margin: [0, 0, 0, 10] // Margen inferior
                        });

                        doc.content.unshift({
                            text: "Fecha:"+fecha_a,
                            fontSize: 10,
                            alignment: "left",
                            margin: [0, 0, 0, 10] // Margen inferior
                        });

                        //Logo
                        doc.content.unshift({
                            image: "data:image/png;base64,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",
                            width: 100,
                            alignment: "left",
                            margin: [0, 0, 0, 10]
                        });

                        //Encabezado
                        doc.styles.tableHeader = {
                            fillColor: "#5bc47c", 
                            color: "white",
                            bold: true,
                            alignment: "center"
                        };
                    }
                },
				{
                    extend: "excelHtml5",
                    text: "Exportar a Excel<i class='bi bi-file-earmark-spreadsheet'></i>",
					className: "btn btn-success",
                    title: "empresa", // Cambia el título
                    customize: function(xlsx) {
                        let sheet = xlsx.xl.worksheets["sheet1.xml"];
                        let empresaNode = `<row r="1"><c t="inlineStr" r="A1"><is><t>${"empresa"}</t></is></c></row>`;
                        let usuarioFechaNode = `<row r="2"><c t="inlineStr" r="A2"><is><t>Usuario: ${"usuario"} | Fecha: ${fecha_a}</t></is></c></row>`;

                        // Agregar empresa y usuario/fecha al inicio del archivo
                        $(sheet).find("sheetData").prepend(usuarioFechaNode);
                        $(sheet).find("sheetData").prepend(empresaNode);
                    }
                },
				{
                    extend: "print",
                    text: "Imprimir<i class='bi bi-printer-fill'></i>",
                    title: "empresa",
					className: "btn btn-primary",
                    customize: function(win) {
                        $(win.document.body).prepend(`
                            <div style="text-align: center; margin-bottom: 10px;">
                                <img src="${"../img/logos/logoInicio.png"}" style="width: 100px; display: block; margin: auto;">
                                <h2>${"empresa"}</h2>
                                <p><strong>Fecha:</strong>  | <strong>Fecha:</strong> ${"fecha"}</p>
                            </div>
                        `);
                    }
                }
				
            ]
        });
		mi_tabla.buttons().container().appendTo("#opc_reporte");
		$("#tabla_paginate").appendTo("#paginas")
        restringir();
        
});


function restringir() {
    let perfil = sessionStorage.getItem("perfil"); 
  
    if (!perfil) {
        console.warn("No se encontró perfil en sessionStorage");
        return;
    }
  
    perfil = JSON.parse(perfil);

    if (perfil.Insercion_ingresos == true){
        document.getElementById("ingresos_dialog").style.display = "block";
    }

    if( perfil.lectura_ingresos == true ){
        document.getElementById("busq").style.display = "block";
        let busq = document.getElementsByClassName("filtrobusq");
        for (let i = 0; i < busq.length; i++) {
           busq[i].style.display = "inline-block";
        }
        if(perfil.edicion_ingresos == true) {
            let estados = document.getElementsByClassName("cambiar-estado");
        let edicion = document.getElementsByClassName("editar-ingreso");
        for (let i = 0; i < edicion.length; i++) {
            edicion[i].style.display = "inline-block";
        }

        for (let i = 0; i < estados.length; i++) {
            estados[i].style.display = "inline-block";
            }
        }
     }

  }