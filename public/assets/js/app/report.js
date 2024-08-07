function generateReport(order) {


        const { jsPDF } = window.jspdf;

        const doc = new jsPDF();

        // Set document properties
        doc.setProperties({
            title: 'Pedidos',
            subject: 'Pedidos',
            author: 'Pedidos',
            keywords: 'invoice, business, pdf',
            creator: 'jsPDF'
        });

        //console.log(order)
    
        // Order Information
        const orderNumber = `PEDIDO: ${order.number}`;
        const customer = `CLIENTE: ${order.customer_name}`;
        const [year, month, day] = order.request_date.split('-');
        const requestDate = `Data: ${day}/${month}/${year}`;
    
        // Function to add header on the first page only
        const addHeader = (doc) => {
            doc.setFontSize(10);
            doc.text(orderNumber, 10, 10);
            doc.text(customer, 10, 15);
            doc.text(requestDate, 10, 20);
        };
    
        // Function to add table rows
        const addTableRows = (doc) => {
            const startX = 10;
            const startY = 30;
            const rowHeight = 10;
            const colWidth = [10, 140, 20, 20]; // Adjust column widths as needed
    
            // Table Headers
            doc.setFontSize(10);
            doc.text("Qtde", startX, startY);
            doc.text("Descrição", startX + colWidth[0], startY);
            doc.text("Unitário", startX + colWidth[0] + colWidth[1], startY, { align : "right", padding: 0 });
            //doc.text("Quantity", startX + colWidth[0] + colWidth[1] + colWidth[2], startY, { align : "right" });
            doc.text("Total", startX + colWidth[0] + colWidth[1] + colWidth[2] + colWidth[3], startY, { align : "right", padding: 0 });
    
            // Table Content
            const items = [];
            order.products.forEach((product) => {
                items.push(
                    { 
                        description: product.description, 
                        unitPrice: parseFloat(product.unitary_value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }), 
                        amount: product.amount, 
                        total: parseFloat(product.amount * product.unitary_value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    }
                );
            });

            items.forEach((item, index) => {
                console.log(item)
                const currentY = startY + (index + 1) * rowHeight;
                //doc.text((index + 1).toString(), startX, currentY);
                doc.text(item.amount, startX, currentY);
                doc.text(item.description, startX + colWidth[0], currentY);
                doc.text(item.unitPrice, startX + colWidth[0] + colWidth[1], currentY, { align : "right", padding: 0 });
                //doc.text(item.quantity.toString(), startX + colWidth[0] + colWidth[1] + colWidth[2], currentY, { align : "right" });
                doc.text(item.total, startX + colWidth[0] + colWidth[1] + colWidth[2] + colWidth[3], currentY, { align : "right", padding: 0 });
    
                // Draw line separator
                doc.setLineWidth(0.1);
                doc.line(startX, currentY + 2, startX + colWidth.reduce((a, b) => a + b, 0), currentY + 2);
                
                // Add new page if content exceeds page limit
                if (currentY > doc.internal.pageSize.height - 20) {
                    doc.addPage();
                    startY = 10;
                }
            });
        };
    
        // Add header only on the first page
        addHeader(doc);
        // Add table rows
        addTableRows(doc);
    
        // Open PDF in a new tab
        const pdfData = doc.output('blob');
        const pdfUrl = URL.createObjectURL(pdfData);
        window.open(pdfUrl, '_blank');    

}


function printOrder(order_id) {
    $.ajax({
        url: `${base_url}/order/print/${order_id}`, // Replace with your endpoint URL
        type: 'GET', // or 'GET'
        dataType: 'json', // Expected data format from the server
        success: function(response) {
            // Handle the response from the server
            //console.log(JSON.stringify(response.order));
            generateReport(response.order);
        },
        error: function(xhr, status, error) {
            // Handle any errors
            console.error('Error: ' + status + ' ' + error);
            $('#result').html('<p>An error occurred: ' + xhr.responseText + '</p>');
        }
    });
}