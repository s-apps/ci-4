function generateReport() {

    const { jsPDF } = window.jspdf;

    const doc = new jsPDF();

    // Set document properties
    doc.setProperties({
        title: 'Business Invoice',
        subject: 'Invoice Details',
        author: 'My Business',
        keywords: 'invoice, business, pdf',
        creator: 'jsPDF'
    });

    // Business Information
    const businessName = "My Business";
    const businessAddress = "123 Business St., Business City";
    const businessContact = "Phone: (123) 456-7890";

    // Function to add header on the first page only
    const addHeader = (doc) => {
        doc.setFontSize(10);
        doc.text(businessName, 10, 10);
        doc.text(businessAddress, 10, 15);
        doc.text(businessContact, 10, 20);
    };

    // Function to add table rows
    const addTableRows = (doc) => {
        const startX = 10;
        const startY = 30;
        const rowHeight = 10;
        const colWidth = [10, 50, 40, 30, 30]; // Adjust column widths as needed

        // Table Headers
        doc.setFontSize(12);
        doc.text("No", startX, startY);
        doc.text("Description", startX + colWidth[0], startY);
        doc.text("Unit Price", startX + colWidth[0] + colWidth[1], startY);
        doc.text("Quantity", startX + colWidth[0] + colWidth[1] + colWidth[2], startY);
        doc.text("Total", startX + colWidth[0] + colWidth[1] + colWidth[2] + colWidth[3], startY);

        // Table Content
        const items = [
            { description: "Item 1", unitPrice: "10.00", quantity: 2, total: "20.00" },
            { description: "Item 2", unitPrice: "15.00", quantity: 3, total: "45.00" },
            { description: "Item 3", unitPrice: "8.00", quantity: 5, total: "40.00" },
        ];

        items.forEach((item, index) => {
            const currentY = startY + (index + 1) * rowHeight;
            doc.text((index + 1).toString(), startX, currentY);
            doc.text(item.description, startX + colWidth[0], currentY);
            doc.text(item.unitPrice, startX + colWidth[0] + colWidth[1], currentY);
            doc.text(item.quantity.toString(), startX + colWidth[0] + colWidth[1] + colWidth[2], currentY);
            doc.text(item.total, startX + colWidth[0] + colWidth[1] + colWidth[2] + colWidth[3], currentY);
            
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