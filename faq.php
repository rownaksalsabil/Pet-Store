<?php
@include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .faq {
            background-color: #ffffff;
            padding: 20px;
            margin: 30px auto;
            width: 80%;
            max-width: 1000px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .faq h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .faq h3 {
            font-size: 22px;
            color: #007bff;
            margin-top: 20px;
        }

        .faq p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }

        .faq p strong {
            font-weight: bold;
        }

        .faq a {
            color: #007bff;
            text-decoration: none;
        }

        .faq a:hover {
            text-decoration: underline;
        }

        .faq button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .faq button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <section id="faq" class="faq">
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to some of the most commonly asked questions about our services and policies.</p>

        <h3>1. What is your shipping time frame?</h3>
        <p>Orders are typically processed and shipped within 2-5 business days. Delivery times may vary based on your location and chosen shipping method.</p>

        <h3>2. How can I track my order?</h3>
        <p>Once your order is shipped, you will receive an email with a tracking number and a link to track your package in real time.</p>

        <h3>3. What payment methods do you accept?</h3>
        <p>We accept credit/debit cards, PayPal, and other secure payment gateways. All transactions are processed securely.</p>

        <h3>4. What is your return policy?</h3>
        <p>Products can be returned within 30 days of purchase if they are in their original condition and packaging. Ensure the product is unused and in resalable condition.</p>

        <h3>5. How do I contact customer support?</h3>
        <p>You can reach our 24/7 customer support team via email, live chat, or our support phone line. We strive to respond within 24 hours.</p>

        <h3>6. Do your products come with a warranty?</h3>
        <p>Yes, we provide a one-year warranty on all products, covering manufacturing defects and faulty parts. It does not cover misuse or accidental damages.</p>

        <h3>7. How do I cancel an order?</h3>
        <p>To cancel an order, contact our customer support team as soon as possible. If the order has not been shipped, we will process the cancellation immediately.</p>

        <h3>8. Is my personal information safe?</h3>
        <p>Yes, we prioritize your privacy. Your personal information is used solely for order fulfillment and improving your shopping experience. We do not share your information without consent.</p>

        <button onclick="window.history.back()">Go Back</button>
    </section>
</body>
</html>
