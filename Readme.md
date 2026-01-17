# WP Site Snapshot Diff (Demo)

This repository contains a small WordPress plugin created to demonstrate a practical approach to capturing, storing, and comparing site health snapshots.

Most of my professional WordPress and plugin development work over the years has been carried out on private commercial and client repositories. This plugin is intended as a representative example of how I structure diagnostic tooling and reason about change detection in WordPress, rather than as a production-ready release.

---

## What this plugin demonstrates

The focus of this plugin is on **data normalization and change detection**, not on UI or automation.

Specifically, it demonstrates:

- Capturing stable, meaningful site health data
- Normalizing snapshot structure for safe comparison
- Persisting snapshots with bounded history
- Producing deterministic diffs between snapshots
- Clear separation of responsibilities between components
- A minimal WordPress admin interface for diagnostics

This mirrors how centralized management systems reason about _what has changed_ on a site over time.

---

## Snapshot data

Each snapshot captures a small, intentionally stable set of information:

- WordPress version
- PHP version
- Active theme name and version
- Active and inactive plugin counts
- WP-Cron disabled flag
- Timestamp

Volatile or sensitive data is deliberately excluded to keep diffs meaningful and predictable.

---

## How it works (high level)

1. A snapshot is captured from the admin interface.
2. Snapshot data is normalized into a fixed structure.
3. Snapshots are stored using the Options API.
4. Only the two most recent snapshots are retained.
5. When two snapshots exist, a structured diff is generated.
6. The diff highlights which values changed and which remained the same.

The plugin avoids deep recursion or generic array diffing in favor of explicit, readable comparison logic.

---

## Architecture overview

The plugin is organized around a few small, focused components:

- **Snapshot Collector**  
  Responsible for gathering and normalizing site data.

- **Snapshot Store**  
  Handles persistence and bounded snapshot history.

- **Diff Engine**  
  Compares two snapshots and produces a structured diff.

- **Admin Page**  
  Provides a minimal diagnostic interface for capturing snapshots and viewing diffs.

Each component has a single responsibility and minimal coupling.

---

## Admin interface

The plugin adds a page under:

**Tools → Site Snapshot Diff**

From there you can:

- Capture a new snapshot
- View the latest snapshot
- View the previous snapshot
- Inspect the diff between them

The interface is intentionally simple and uses standard WordPress admin patterns.

---

## Notes

- This plugin is designed for demonstration and discussion purposes.
- No client or proprietary code is included.
- The implementation favors clarity and predictability over abstraction.

---

## License

GPL-2.0+
