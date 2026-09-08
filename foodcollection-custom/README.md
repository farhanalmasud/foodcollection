# FoodCollection Custom Work

All FoodCollection-specific changes live here so you can re-apply them after every **6amMart / CodeCanyon** script update.

## Folder structure

```
foodcollection-custom/
├── README.md                 ← You are here
├── APPLY-AFTER-UPDATE.md     ← Step-by-step after script update
├── INDEX.md                  ← List of all customizations
├── modules/                  ← Full custom modules (copy → Modules/)
├── patches/                  ← Core file edits (FC-CUSTOM blocks)
├── config/                   ← JSON/lang additions
└── scripts/
    └── apply.sh              ← Auto-copy modules + migrate
```

## Quick apply after 6amMart update

```bash
cd /path/to/portal.foodcollections.com
bash foodcollection-custom/scripts/apply.sh
```

Then apply **patches** (see `APPLY-AFTER-UPDATE.md` or ask Cursor: *"Apply all foodcollection-custom patches"*).

## Rules

1. **Never run `git clean` on production** — it deletes untracked server files.
2. After script update, only replace vendor/core files — keep `foodcollection-custom/` and `Modules/IpCallBdSms/`.
3. Search `FC-CUSTOM` in codebase after update — re-insert missing blocks from `patches/`.
4. Local notes also in `Documentation/` (gitignored, backup separately).

## Deploy to server

This folder is **in git** — `git pull` brings it to the server. Then run `apply.sh`.
