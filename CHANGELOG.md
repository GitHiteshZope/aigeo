# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-03-24

### Added
- `HasGeoProfile` trait for Eloquent models
- `SchemaBuilder` with Product, FAQ, Review, Breadcrumb, Organization schemas
- `LlmsTxtGenerator` — auto-generates /llms.txt and /llms-full.txt
- `GeoScorer` — 10-signal GEO audit score (0–100, A–F grading)
- `CitationEngine` — enriches descriptions with AI-citation signals
- `AISitemapGenerator` — AI-first XML sitemap
- `ProductFeedGenerator` — /ai-product-feed.json endpoint
- `<x-geo-head>` Blade component
- `@geo_schema` and `@geo_faq` Blade directives
- `InjectGeoHeaders` middleware
- Artisan commands: `geo:llms-txt`, `geo:audit`, `geo:feed`
- Visual Dashboard with 6 management pages
- Full test suite (Pest)
