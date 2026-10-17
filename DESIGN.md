---
name: Academic Utility
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#44474e'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#74777f'
  outline-variant: '#c4c6cf'
  surface-tint: '#495f82'
  primary: '#001026'
  on-primary: '#ffffff'
  primary-container: '#0b2545'
  on-primary-container: '#778db2'
  inverse-primary: '#b1c7f0'
  secondary: '#904d00'
  on-secondary: '#ffffff'
  secondary-container: '#fe932c'
  on-secondary-container: '#663500'
  tertiary: '#001027'
  on-tertiary: '#ffffff'
  tertiary-container: '#00254c'
  on-tertiary-container: '#688dc6'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d5e3ff'
  primary-fixed-dim: '#b1c7f0'
  on-primary-fixed: '#001c3b'
  on-primary-fixed-variant: '#314769'
  secondary-fixed: '#ffdcc3'
  secondary-fixed-dim: '#ffb77d'
  on-secondary-fixed: '#2f1500'
  on-secondary-fixed-variant: '#6e3900'
  tertiary-fixed: '#d5e3ff'
  tertiary-fixed-dim: '#a7c8ff'
  on-tertiary-fixed: '#001c3b'
  on-tertiary-fixed-variant: '#1d477c'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-xl:
    fontFamily: Inter
    fontSize: 2.25rem
    fontWeight: '700'
    lineHeight: 2.75rem
    letterSpacing: -0.025em
  headline-xl-mobile:
    fontFamily: Inter
    fontSize: 1.75rem
    fontWeight: '700'
    lineHeight: 2.25rem
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 1.875rem
    fontWeight: '700'
    lineHeight: 2.25rem
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: 2rem
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Inter
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: 2rem
    letterSpacing: -0.015em
  headline-sm:
    fontFamily: Inter
    fontSize: 1.25rem
    fontWeight: '600'
    lineHeight: 1.75rem
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Inter
    fontSize: 1.125rem
    fontWeight: '400'
    lineHeight: 1.75rem
  body-md:
    fontFamily: Inter
    fontSize: 1rem
    fontWeight: '400'
    lineHeight: 1.5rem
  body-sm:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '400'
    lineHeight: 1.25rem
  label-lg:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '600'
    lineHeight: 1.25rem
    letterSpacing: 0.01em
  label-md:
    fontFamily: Inter
    fontSize: 0.75rem
    fontWeight: '600'
    lineHeight: 1rem
    letterSpacing: 0.025em
  label-sm:
    fontFamily: Inter
    fontSize: 0.6875rem
    fontWeight: '700'
    lineHeight: 0.875rem
    letterSpacing: 0.05em
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
  space-2xl: 3rem
---

## Brand & Style

This design system establishes an authoritative, institutional, and dependable visual standard for campus network infrastructure and utility access. Built to balance collegiate prestige with modern enterprise clarity, the interface projects reliability, uptime security, and transparent self-service administration for faculty, staff, and students.

The aesthetic follows a **Corporate / Modern** framework characterized by:
- **Crisp Structural Discipline:** Rational 1px borders, compact data cards, and unambiguous functional demarcations rather than decorative embellishments.
- **Academic Authority:** Anchored by traditional deep navy tones balanced with deliberate amber-gold accents that signal alerts, priority statuses, and actionable tiers.
- **Engineering Velocity:** Designed for rapid engineering execution in tight sprint cycles, utilizing consistent standard box-model patterns, predictable vertical rhythms, and zero non-standard layout hacks.
- **High Legibility Under Duress:** Maximum contrast ratios meeting WCAG AAA requirements for dense status dashboards, device management consoles, and financial transaction tables.

## Colors

The palette leverages high-contrast institutional tones paired with a functional slate-neutral hierarchy.

### Core Swatches
- **Primary (`#0B2545` - Deep Navy):** Represents stability, governance, and institutional identity. Used for primary buttons, top navigation bars, key brand anchors, and terminal headings.
- **Secondary (`#D97706` - Warm Ochre / Amber):** The campus accent color. Reserved for high-intent actions, renewal warnings, key feature highlights, and active state indicators.
- **Tertiary (`#134074` - Academic Slate Blue):** Bridges dark navy surfaces and neutral content areas; applied to active tab strokes, secondary controls, and interactive data filters.
- **Neutral (`#64748B` - Cool Slate):** Governs secondary typography, breadcrumb paths, and meta-information.

### Surface & Border Hierarchy
- **Canvas Base:** `#F8FAFC` (Slate 50) provides a glare-free, cool architectural foundation that reduces eye strain in institutional work environments.
- **Surface Elevation (Cards, Modals):** Pure `#FFFFFF` ensures crisp separation from the canvas.
- **Dividers & Strokes:** `#E2E8F0` (Slate 200) for standard card borders, grid dividers, and table rows; `#CBD5E1` (Slate 300) for input borders and interactive hover perimeters.

### Semantic Status Indicators
- **Active / Operational:** `#059669` (Emerald 600) with `#ECFDF5` (Emerald 50) fill.
- **Expiring Soon / Warning:** `#D97706` (Amber 600) with `#FFFBEB` (Amber 50) fill.
- **Expired / Inactive / Danger:** `#DC2626` (Red 600) with `#FEF2F2` (Red 50) fill.
- **Informational / Processing:** `#0284C7` (Sky 600) with `#F0F9FF` (Sky 50) fill.

## Typography

The typographic hierarchy utilizes `Inter` across all structural tiers to deliver neutral clarity, high x-height readability, and systematic vertical proportions.

- **Weight Distribution:** 
  - Headlines strictly utilize `600` (SemiBold) or `700` (Bold) to project administrative certainty.
  - Body text is set to `400` (Regular) for sustained reading of policy documents and documentation.
  - Interactive triggers, tabular numbers, and badge labels utilize `600` to prevent visual bleeding.
- **Tabular Figures:** All numeric displays (bandwidth consumption, balance figures, IP addresses, dates) must enable OpenType tabular figures (`font-variant-numeric: tabular-nums`) to preserve column alignment inside telemetry modules and financial breakdowns.
- **Letter Spacing:** Tighter negative tracking is enforced on sizes `1.25rem` and above to prevent optical sprawl; positive letter spacing (`0.025em` to `0.05em`) is enforced on uppercase status badges and micro-labels.

## Layout & Spacing

Layout geometry follows an absolute 8-point base grid system (with 4-point micro-adjustments for labels and compact inputs).

### Structural Architecture
- **Desktop Grid:** 12-column fluid grid constrained to a maximum width of `1280px` (`max-w-7xl`), centered within the viewport.
- **Tablet Grid (768px - 1023px):** 8-column layout with fixed `1.5rem` outer margins. Sidebars collapse into sticky top utility drawers.
- **Mobile Grid (< 768px):** 4-column layout with `1rem` outer canvas padding. Stack multi-column pricing and telemetry cards into full-width vertical blocks.

### Layout Rhythm
- Dashboard cards and operational metric tiles use `space-lg` (`1.5rem`) internal padding on desktop, scaling down to `space-md` (`1rem`) on viewports under 640px.
- Dense data listings, device tables, and setting rows enforce `space-sm` (`0.5rem`) to `space-md` (`1rem`) vertical rhythm to maximize visible payload per scroll window.

## Elevation & Depth

To preserve an institutional, low-latency utility aesthetic and prevent rendering inconsistencies across institutional hardware, this system avoids deep blur drops, colored glows, and heavy skeuomorphic projections. Depth is achieved via **low-contrast outlines** and **subtle ambient resting drops**.

- **Level 0 (Flat / Canvas):** Applied to the base canvas (`#F8FAFC`). No shadow.
- **Level 1 (Resting Cards & Containers):** Pure `#FFFFFF` surface enclosed by a 1px solid stroke in `#E2E8F0` coupled with an ultra-subtle ambient drop: `box-shadow: 0 1px 2px 0 rgba(11, 37, 69, 0.05)`.
- **Level 2 (Interactive Hover / Segmented Controls):** Applied when cards, data rows, or utility modules enter hover/focus states: border transitions to `#CBD5E1`, with elevation rising to `box-shadow: 0 4px 6px -1px rgba(11, 37, 69, 0.07), 0 2px 4px -2px rgba(11, 37, 69, 0.05)`.
- **Level 3 (Dropdown Menus & Overlays):** Used for navigation sub-menus, profile switchers, and tooltips: 1px border `#E2E8F0`, elevated via `box-shadow: 0 10px 15px -3px rgba(11, 37, 69, 0.08), 0 4px 6px -4px rgba(11, 37, 69, 0.04)`.
- **Level 4 (Modal Dialogs & Critical Interrupts):** Centered dialogs sit atop a 60% opacity `#0B2545` backdrop overlay, bounded by 1px solid `#E2E8F0` and `box-shadow: 0 20px 25px -5px rgba(11, 37, 69, 0.15)`.

## Shapes

The visual personality relies on strict, structural engineering shapes. A soft roundedness level (`roundedness: 1`) is applied uniformly:

- **Base Radius (`0.25rem` / `rounded`):** Default for form inputs, standard buttons, data table cells, and status badges. Reinforces institutional precision.
- **Container Radius (`0.5rem` / `rounded-lg`):** Standard for main content cards, tier pricing blocks, and modular containers.
- **Overlay Radius (`0.75rem` / `rounded-xl`):** Reserved exclusively for modal dialogs and alert panels.
- **Pill Exceptions:** Rounded-full is prohibited for cards, inputs, and primary CTAs; it is reserved exclusively for small numeric counter chips and circular user avatar fallbacks.

## Components

### Buttons
- **Primary:** Solid `#0B2545` background, `#FFFFFF` text, `0.25rem` radius. Hover: `#134074`. Active: `#07182C`. Focus: 2px offset with `#0B2545` outline.
- **Secondary / Action:** Solid `#D97706` background, `#FFFFFF` text. Hover: `#B45309`. Focus: 2px offset with `#D97706` outline.
- **Outline / Secondary Neutral:** White background, 1px `#E2E8F0` border, `#0B2545` text. Hover: `#F8FAFC` background, `#CBD5E1` border.
- **Destructive:** White background, 1px `#FECACA` border, `#DC2626` text. Hover: `#FEF2F2`.

### Status Badges (Pills & Chips)
- **Structure:** `0.25rem` radius, `0.125rem 0.5rem` padding, `label-md` uppercase typography with a 6px status dot.
- **Active:** Background `#ECFDF5`, text `#065F46`, dot `#059669`.
- **Expiring Soon:** Background `#FFFBEB`, text `#92400E`, dot `#D97706`.
- **Expired / Disconnected:** Background `#FEF2F2`, text `#991B1B`, dot `#DC2626`.

### Cards & Pricing Tiers
- **Standard Card:** Background `#FFFFFF`, 1px solid `#E2E8F0`, `0.5rem` border radius, `1.5rem` internal padding.
- **Featured / Recommended Pricing Tier:** 2px solid `#0B2545` perimeter. A prominent `#0B2545` header badge anchoring the top right ("POPULAR" / "FACULTY CHOICE"). Key bandwidth and data limits rendered in `headline-xl` with tabular alignment.

### Data Tables
- **Header:** Background `#F8FAFC`, bottom border 1px solid `#E2E8F0`, uppercase `label-md` text `#64748B`.
- **Rows:** Alternating subtle row hover (`#F8FAFC`), bottom border 1px solid `#F1F5F9`, vertical cell padding `0.75rem 1rem`. Numeric metrics right-aligned with monospace/tabular-nums enabled.

### Form Inputs & Checkboxes
- **Input Fields:** Background `#FFFFFF`, border 1px solid `#CBD5E1`, text `#0B2545`, placeholder `#94A3B8`, radius `0.25rem`. Height `2.5rem` (compact desktop). Focus state: border `#0B2545`, ring 1px `#0B2545`.
- **Checkboxes & Radios:** Primary accent color `#0B2545` when checked, 1px `#CBD5E1` rest state border.

### Network Metric Widgets
- Telemetry modules featuring data quota progress bars must utilize a dual-tone track: background `#E2E8F0`, filled with `#0B2545` (normal usage) or `#D97706` (exceeding 85% bandwidth threshold).