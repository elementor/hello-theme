const https = require('https');

const slackToken = process.env.CLOUD_SLACK_BOT_TOKEN || '';
const slackChannel = process.env.SLACK_CHANNEL || '#tmz-alerts';
const payloadJson = process.env.SLACK_PAYLOAD || '{}';

if (!slackToken) {
  console.log('⚠️ Slack token not provided, skipping notification');
  process.exit(0);
}

let payload;
try {
  payload = JSON.parse(payloadJson);
  payload.channel = slackChannel;
} catch (error) {
  console.error('Failed to parse payload:', error.message);
  process.exit(1);
}

const payloadStr = JSON.stringify(payload);
const data = Buffer.from(payloadStr, 'utf8');

const options = {
  hostname: 'slack.com',
  port: 443,
  path: '/api/chat.postMessage',
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${slackToken}`,
    'Content-Type': 'application/json',
    'Content-Length': data.length
  }
};

const req = https.request(options, (res) => {
  let responseData = '';
  res.on('data', (chunk) => {
    responseData += chunk;
  });
  res.on('end', () => {
    const response = JSON.parse(responseData);
    if (res.statusCode === 200 && response.ok) console.log('✅ Slack notification sent');
    process.exit(0);
  });
});

req.on('error', (error) => {
  console.error('Failed to send Slack notification');
  process.exit(0);
});

req.write(data);
req.end();

