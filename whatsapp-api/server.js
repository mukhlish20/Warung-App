const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');
require('dotenv').config();

const app = express();
app.use(express.json());

// WhatsApp Client
const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: './wa-session'
    }),
    puppeteer: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu'
        ]
    }
});

let isReady = false;

// Event: QR Code
client.on('qr', (qr) => {
    console.log('\n========================================');
    console.log('📱 SCAN QR CODE DENGAN WHATSAPP ANDA:');
    console.log('========================================\n');
    qrcode.generate(qr, { small: true });
    console.log('\n========================================');
});

// Event: Authenticated
client.on('authenticated', () => {
    console.log('✅ WhatsApp Authenticated!');
});

// Event: Ready
client.on('ready', () => {
    console.log('✅ WhatsApp Client is ready!');
    console.log('🚀 Server siap menerima request');
    isReady = true;
});

// Event: Disconnected
client.on('disconnected', (reason) => {
    console.log('❌ WhatsApp Client disconnected:', reason);
    isReady = false;
});

// Initialize WhatsApp Client
console.log('🔄 Initializing WhatsApp Client...');
client.initialize();

// ==========================================
// MIDDLEWARE: Check API Key
// ==========================================
const checkApiKey = (req, res, next) => {
    const apiKey = req.headers['authorization']?.replace('Bearer ', '');
    const validApiKey = process.env.API_KEY || 'warung-app-secret-key';

    if (apiKey !== validApiKey) {
        return res.status(401).json({
            success: false,
            error: 'Invalid API Key'
        });
    }

    next();
};

// ==========================================
// ROUTES
// ==========================================

// Health Check
app.get('/health', (req, res) => {
    res.json({
        success: true,
        status: isReady ? 'ready' : 'not ready',
        timestamp: new Date().toISOString()
    });
});

// Send Message
app.post('/send-message', checkApiKey, async (req, res) => {
    const { phone, message } = req.body;

    // Validasi
    if (!phone || !message) {
        return res.status(400).json({
            success: false,
            error: 'Phone and message are required'
        });
    }

    // Cek WhatsApp ready
    if (!isReady) {
        return res.status(503).json({
            success: false,
            error: 'WhatsApp client is not ready'
        });
    }

    try {
        // Format nomor WhatsApp
        const chatId = phone.includes('@') ? phone : phone + '@c.us';
        
        // Kirim pesan
        await client.sendMessage(chatId, message);

        console.log(`✅ Message sent to ${phone}`);

        res.json({
            success: true,
            message: 'Message sent successfully',
            to: phone,
            timestamp: new Date().toISOString()
        });

    } catch (error) {
        console.error('❌ Error sending message:', error);

        res.status(500).json({
            success: false,
            error: error.message
        });
    }
});

// Get Client Info
app.get('/info', checkApiKey, async (req, res) => {
    if (!isReady) {
        return res.status(503).json({
            success: false,
            error: 'WhatsApp client is not ready'
        });
    }

    try {
        const info = client.info;
        res.json({
            success: true,
            data: {
                phone: info.wid.user,
                platform: info.platform,
                pushname: info.pushname
            }
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            error: error.message
        });
    }
});

// ==========================================
// START SERVER
// ==========================================
const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log('\n========================================');
    console.log(`🚀 WhatsApp API Server running on port ${PORT}`);
    console.log('========================================\n');
    console.log('Endpoints:');
    console.log(`  GET  http://localhost:${PORT}/health`);
    console.log(`  POST http://localhost:${PORT}/send-message`);
    console.log(`  GET  http://localhost:${PORT}/info`);
    console.log('\n========================================\n');
});

