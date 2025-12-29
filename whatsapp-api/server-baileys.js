const { default: makeWASocket, DisconnectReason, useMultiFileAuthState, fetchLatestBaileysVersion } = require('@whiskeysockets/baileys');
const express = require('express');
const pino = require('pino');
require('dotenv').config();

const app = express();
app.use(express.json());

let sock;
let isReady = false;

async function connectToWhatsApp() {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info_baileys');
    const { version } = await fetchLatestBaileysVersion();
    
    sock = makeWASocket({
        version,
        auth: state,
        printQRInTerminal: true,
        logger: pino({ level: 'silent' }),
        browser: ['Warung App', 'Chrome', '1.0.0']
    });

    sock.ev.on('creds.update', saveCreds);
    
    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;
        
        if (qr) {
            console.log('\n========================================');
            console.log('📱 SCAN QR CODE DI ATAS DENGAN WHATSAPP');
            console.log('========================================\n');
        }
        
        if (connection === 'close') {
            const shouldReconnect = lastDisconnect?.error?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('❌ Connection closed. Reconnecting:', shouldReconnect);
            
            if (shouldReconnect) {
                setTimeout(() => connectToWhatsApp(), 3000);
            }
        } else if (connection === 'open') {
            console.log('\n========================================');
            console.log('✅ WhatsApp Connected Successfully!');
            console.log('========================================\n');
            isReady = true;
        }
    });

    sock.ev.on('messages.upsert', async ({ messages }) => {
        // Handle incoming messages if needed
    });
}

connectToWhatsApp();

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
        const jid = phone.includes('@') ? phone : phone + '@s.whatsapp.net';
        
        // Kirim pesan
        await sock.sendMessage(jid, { text: message });

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
    if (!isReady || !sock) {
        return res.status(503).json({
            success: false,
            error: 'WhatsApp client is not ready'
        });
    }

    try {
        const info = sock.user;
        res.json({
            success: true,
            data: {
                phone: info.id.split(':')[0],
                name: info.name || 'Unknown'
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
    console.log(`🚀 WhatsApp API Server (Baileys) running on port ${PORT}`);
    console.log('========================================\n');
    console.log('Endpoints:');
    console.log(`  GET  http://localhost:${PORT}/health`);
    console.log(`  POST http://localhost:${PORT}/send-message`);
    console.log(`  GET  http://localhost:${PORT}/info`);
    console.log('\n========================================\n');
});

