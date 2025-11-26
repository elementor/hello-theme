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
    if (res.statusCode === 200) {
      const response = JSON.parse(responseData);
      if (response.ok) {
        console.log('✅ Slack notification sent');
      } else {
        console.error('Slack API error:', response.error);
      }
    } else {
      console.error(`Slack API returned status ${res.statusCode}`);
    }
    process.exit(0);
  });
});

req.on('error', (error) => {
  // Remove newline characters from error message before logging
  const sanitizedMessage = typeof error.message === "string" ? error.message.replace(/[\r\n]+/g, "") : String(error.message);
  console.error('Request error:', sanitizedMessage);
  process.exit(0);
});

req.write(data);
req.end();

