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

$("#exportarExcel").click(function(){
	exportarAExcel();
	alert("Reporte generado con exito.");
});