// Import the Nodemailer module
const nodemailer = require('nodemailer');

// Get the recipient email address from command-line argument
const recipientEmail = process.argv[2];

// Check if recipient email address is provided
if (!recipientEmail) {
    console.error('Recipient email address is missing.');
    process.exit(1);
}

// Create a transporter object using SMTP transport
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: 'classiccreation.25@gmail.com',
        pass: 'azxm xxgn ilkk jlkk'
    }
});

// Define email options
const mailOptions = {
    from: 'classiccreation.25@gmail.com',
    to: recipientEmail, // Set recipient email dynamically
    subject: 'Account Registration Successful', // Modify subject as needed
    text: `Dear User,\n\nThank you for registering with Classic Creation. Your account has been successfully created.\n\nYou can now log in to your account and start exploring our platform.\n\nBest regards,\nClassic Creation Team` // Modify email content as needed
}; 

// Send email
transporter.sendMail(mailOptions, function(error, info){
    if (error) {
        console.log('Error occurred:', error);
    } else {
        console.log('Email sent:', info.response);
    }
});
