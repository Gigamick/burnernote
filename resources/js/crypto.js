/**
 * Client-side encryption utilities using Web Crypto API
 * Uses AES-GCM for authenticated encryption
 */

export async function generateKey() {
    const key = await window.crypto.subtle.generateKey(
        { name: 'AES-GCM', length: 256 },
        true,
        ['encrypt', 'decrypt']
    );
    return key;
}

export async function exportKey(key) {
    const exported = await window.crypto.subtle.exportKey('raw', key);
    return btoa(String.fromCharCode(...new Uint8Array(exported)));
}

export async function importKey(base64Key) {
    const keyData = Uint8Array.from(atob(base64Key), c => c.charCodeAt(0));
    return await window.crypto.subtle.importKey(
        'raw',
        keyData,
        { name: 'AES-GCM', length: 256 },
        false,
        ['decrypt']
    );
}

export async function encrypt(plaintext, key) {
    const encoder = new TextEncoder();
    const data = encoder.encode(plaintext);
    const iv = window.crypto.getRandomValues(new Uint8Array(12));

    const encrypted = await window.crypto.subtle.encrypt(
        { name: 'AES-GCM', iv },
        key,
        data
    );

    // Combine IV + ciphertext and base64 encode
    const combined = new Uint8Array(iv.length + encrypted.byteLength);
    combined.set(iv);
    combined.set(new Uint8Array(encrypted), iv.length);

    return btoa(String.fromCharCode(...combined));
}

export async function decrypt(ciphertext, key) {
    const combined = Uint8Array.from(atob(ciphertext), c => c.charCodeAt(0));
    const iv = combined.slice(0, 12);
    const data = combined.slice(12);

    const decrypted = await window.crypto.subtle.decrypt(
        { name: 'AES-GCM', iv },
        key,
        data
    );

    const decoder = new TextDecoder();
    return decoder.decode(decrypted);
}
