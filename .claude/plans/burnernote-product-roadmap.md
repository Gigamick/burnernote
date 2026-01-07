# Burnernote Product Roadmap

## Vision
Burnernote becomes the trusted standard for ephemeral sensitive communication.

---

## Phase 1: Delight & Polish
- [x] QR code on note summary page
- [ ] ~~Burn animation when note is destroyed~~ (removed - was awful)

## Phase 2: Sender Confidence
- [x] Sender receipt/status page ("Did they read it?")
- [ ] Optional email notification when note is read

## Phase 3: Flexibility
- [ ] Multiple views option (1, 3, 5, or unlimited until expiry)
- [ ] View counter shown to recipient

## Phase 4: Zero Knowledge
- [x] Client-side encryption (encrypt in browser)
- [x] Decryption key in URL fragment (never hits server)
- [x] Update marketing copy to emphasize zero-knowledge

## Phase 5: Social Proof
- [x] Live burn counter on homepage (seeded with 57,634 from legacy DB)
- [x] "X notes securely destroyed" with real-time updates

## Phase 6: Power Features
- [ ] File attachments (encrypted, <10MB)
- [ ] Developer API
- [ ] CLI tool

## Phase 7: Business
- [ ] Pro tier (larger notes, files, longer expiry)
- [ ] Team/business accounts
- [ ] Audit logs
- [ ] Custom branding

---

## Implementation Notes

### QR Code (Phase 1)
- Use lightweight JS library (qrcode.js or similar)
- Display on note-summary.blade.php alongside the link
- Styled to match the soft/modern aesthetic

### Burn Animation (Phase 1)
- CSS animation on note.blade.php
- Trigger after note content is displayed
- Paper dissolving/burning effect
- "This note has been permanently destroyed" confirmation with timestamp

### Sender Receipt (Phase 2)
- Generate receipt_token on note creation
- New table or columns: receipt_token, viewed_at
- Status page: /receipt/{token}
- Shows: Pending → Viewed (timestamp) → Destroyed

### Client-Side Encryption (Phase 4)
- Use Web Crypto API (SubtleCrypto)
- Generate key in browser, encrypt before POST
- Key appended to URL as fragment (#key=xxx)
- Server stores only ciphertext
- Decrypt in browser on view