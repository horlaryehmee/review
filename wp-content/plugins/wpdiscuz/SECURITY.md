# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 7.6.44  | :white_check_mark: |
| 7.6.43  | :white_check_mark: |
| < 7.6.43| :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability within wpDiscuz, please send an email to info@gvectors.com. All security vulnerabilities will be promptly addressed.

## Security Fixes

### CVE-2025-68997 - IDOR Vulnerability (Fixed in 7.6.44)

**Severity:** Medium
**Type:** Insecure Direct Object Reference (IDOR)
**Affected Actions:** `wpdVoteOnComment`, `wpdUserRate`, `wpdFollowUser`, `wpdAddSubscription`

**Description:**
AJAX actions exposed via `admin-ajax.php` were vulnerable to:
1. Authorization bypass - voting on comments from private/restricted posts
2. Mass abuse through direct HTTP requests bypassing frontend protections

**Fix Applied:**
1. **Authorization Check** (IDOR fix):
   - Added post access validation to `voteOnComment()`
   - Verifies post exists and is published
   - Checks user has permission for private posts
   - Blocks access to password-protected post comments for guests
   - Uses `$comment->comment_post_ID` (actual post from DB) for authorization, not user-supplied `postId` parameter - prevents bypass via parameter manipulation

2. **Rate Limiting** (Abuse prevention):
   - Server-side rate limiting on all sensitive AJAX actions
   - Rate limits: vote (20/min), rate (10/min), follow (15/min), subscribe (10/min)
   - Enhanced client fingerprinting (IP + User-Agent + Accept-Language)
   - Rate limiting executes BEFORE nonce validation for maximum protection

**Files Modified:**
- `utils/class.WpdiscuzHelper.php` - Added `checkRateLimit()` and `getClientFingerprint()`
- `utils/class.WpdiscuzHelperAjax.php` - Authorization check + rate limiting on `voteOnComment()`, `userRate()`, `followUser()`
- `utils/class.WpdiscuzHelperEmail.php` - Rate limiting on `addSubscription()`
- `options/class.WpdiscuzOptions.php` - Added `wc_rate_limit_exceeded` phrase

**Verification:**
Security fix can be verified by checking for `@security-fix CVE-2025-68997` annotations in the source code.

## Security Best Practices

1. Always keep wpDiscuz updated to the latest version
2. Use HTTPS on your website
3. Keep WordPress core and other plugins updated
4. Use strong passwords for admin accounts
5. Consider using a Web Application Firewall (WAF)
