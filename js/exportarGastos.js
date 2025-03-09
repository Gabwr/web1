// JavaScript Document
var tabla=document.getElementById("tabla");
var tablaC=tabla.cloneNode(true);
function exportarAExcel()
{
   let wb = XLSX.utils.book_new();
   let ws = XLSX.utils.table_to_sheet(tablaC);
    let range = XLSX.utils.decode_range(ws['!ref']);
     let colWidths = [];
    for (let C = range.s.c; C <= range.e.c; ++C) {
        let maxWidth = 10;
        for (let R = range.s.r; R <= range.e.r; ++R) {
            let cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
            let cell = ws[cellAddress];
            if (cell && cell.v) {
                let cellText = cell.v.toString();
                maxWidth = Math.max(maxWidth, cellText.length + 2);
            }
        }
        colWidths.push({ wch: maxWidth });
    }
	for (let C = range.s.c; C <= range.e.c; ++C) {
        let cellAddress = XLSX.utils.encode_cell({ r: 0, c: C }); // Primera fila (encabezado)
        if (ws[cellAddress]) {
            ws[cellAddress].s = {
                font: { bold: true, color: { rgb: "FFFFFF" }, sz: 14 }, // Negrita, blanco, tamaño 14
                fill: { fgColor: { rgb: "0070C0" } }, // Fondo azul
                alignment: { horizontal: "center" } // Centrado
            };
        }
    }
    ws['!cols'] = colWidths;
	XLSX.utils.book_append_sheet(wb, ws, "Datos");
	//let wbout = XLSX.write(wb, { bookType: "xlsx", type: "array" });
	XLSX.writeFile(wb, "tabla.xlsx"); // Descargar el archivo Excel
	
}

function exportarAPdf()
{
	const { jsPDF } = window.jspdf; // ✅ Asegurar que jsPDF está definido 
	let doc = new jsPDF();

    // 🔹 Cargar logo desde una URL o base64
    let logo = new Image();
    logo.src = "../img/logos/logoInicio.png"; // ⬅️ Cambia esta URL por la de tu logo

    logo.onload = function () {
        // 🔹 Dibujar el logo en el PDF
        doc.addImage(logo, "PNG", 14, 10, 30, 15); // (imagen, formato, x, y, ancho, alto)

        // 🔹 Datos del encabezado
        let empresa = "Finanzas Familiares";
        let usuario = "Marcelo Pareja";
        let fecha = new Date().toLocaleDateString();

        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.text(empresa, 105, 15, { align: "center" });

        doc.setFontSize(12);
        doc.text("Reporte de Gastos", 105, 25, { align: "center" });

        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");
        doc.text(`Fecha: ${fecha}`, 14, 35);
        doc.text(`Usuario: ${usuario}`, 14, 42);

        // 🔹 Convertir la tabla a PDF con autoTable
        doc.autoTable({
            html: "#tabla",
            startY: 50, // ⬅️ Asegurar que la tabla no se sobreponga con el encabezado
            theme: "grid",
            headStyles: { fillColor: [0, 112, 192], textColor: 255, fontStyle: "bold" },
            styles: { fontSize: 10, cellPadding: 3 },
            margin: { top: 10 }
        });

        // 🔹 Descargar el PDF
        doc.save("Reporte.pdf");
    };
}
$("#exportarExcel").click(function(){
	exportarAExcel();
	alert("Reporte generado con exito.");
});
$("#exportarPDF").click(function(){
	exportarAPdf();
	alert("Reporte generado con exito.");
});