const crypto = require('crypto');

function encrypt(value, serialize = true, key) {
    // Generate a random IV (Initialization Vector)
    const iv = crypto.randomBytes(16);

    // Serialize the value if needed
    const serializedValue = serialize ? JSON.stringify(value) : value;

    // Create a cipher using AES-128-CBC algorithm
    const cipher = crypto.createCipheriv('aes-128-cbc', Buffer.from(key), iv);

    // Update the cipher with the serialized value and finalize it
    let encryptedValue = cipher.update(serializedValue, 'utf8', 'base64');
    encryptedValue += cipher.final('base64');

    // Base64 encode the IV and encrypted value
    const ivBase64 = iv.toString('base64');
    const tagBase64 = ''; // Since OpenSSL returns the tag/MAC

    // Calculate the MAC (Message Authentication Code)
    const hmac = crypto.createHmac('sha256', key);
    hmac.update(ivBase64 + encryptedValue);
    const mac = hmac.digest('hex');

    // Create an object with IV, encrypted value, MAC, and tag
    const payload = {
        iv: ivBase64,
        value: encryptedValue,
        mac: mac,
        tag: tagBase64,
    };

    // Convert the object to JSON
    const jsonPayload = JSON.stringify(payload);

    // Base64 encode the JSON payload
    const base64Payload = Buffer.from(jsonPayload).toString('base64');

    return base64Payload;
}

module.exports = encrypt;
