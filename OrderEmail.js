const nodemailer = require('nodemailer');

// Create a transporter object using SMTP transport
const transporter = nodemailer.createTransport({
    host: 'smtp.example.com',
    port: 465,
    secure: true, // Use SSL
    auth: {
        user: 'classiccreation.25@gmail.com',
        pass: 'azxm xxgn ilkk jlkk'
    }
});

// Function to send order summary email
function sendOrderSummaryEmail(email, productName, quantity, totalAmount) {
    // Create email message
    const message = {
        from: 'classiccreation.25@gmail.com',
        to: email,
        subject: 'Order Summary',
        text: `Thank you for your order. Here is the summary:\nProduct Name: ${productName}\nQuantity: ${quantity}\nTotal Amount: ${totalAmount}`
    };

    // Send email
    transporter.sendMail(message, (error, info) => {
        if (error) {
            console.error('Error sending email:', error);
        } else {
            console.log('Email sent:', info.response);
        }
    });
}

module.exports = sendOrderSummaryEmail;