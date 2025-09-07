# SCSS Setup für Travel Pimcore

## Struktur

Die SCSS-Dateien sind wie folgt organisiert:

```
assets/scss/
├── abstracts/           # Variablen, Mixins, Funktionen
│   ├── _variables.scss  # Alle Projekt-Variablen
│   └── _mixins.scss     # Wiederverwendbare Mixins
├── base/               # Basis-Styles
│   ├── _reset.scss     # CSS Reset und Basis-Styles
│   └── _typography.scss # Typografie-Styles
├── layouts/            # Layout-Komponenten
│   ├── _container.scss # Container-Styles
│   ├── _header.scss    # Header/Navigation
│   └── _footer.scss    # Footer-Styles
├── components/         # UI-Komponenten
│   └── _destination-grid.scss # Destination Grid Komponente
└── main.scss           # Haupt-SCSS-Datei mit allen Imports
```

## Kompilierung

### Installation
```bash
npm install
```

### Entwicklung (mit Watch-Modus)
```bash
npm run dev
# oder
npm run watch-css
```

### Production Build (komprimiert)
```bash
npm run build
# oder
npm run build-css
```

Die kompilierte CSS-Datei wird hier erstellt:
```
public/build/css/main.css
```

## Verwendung

Die kompilierte CSS-Datei wird automatisch in `templates/layouts/layout.html.twig` eingebunden:

```twig
<link rel="stylesheet" href="{{ asset('build/css/main.css') }}">
```

## Neue Komponenten hinzufügen

1. Neue SCSS-Datei im entsprechenden Ordner erstellen:
   ```scss
   // assets/scss/components/_new-component.scss
   @import '../abstracts/variables';
   @import '../abstracts/mixins';
   
   .new-component {
       // Styles hier
   }
   ```

2. In `main.scss` importieren:
   ```scss
   @import 'components/new-component';
   ```

3. CSS neu kompilieren:
   ```bash
   npm run build
   ```

## Verfügbare Variablen

Die wichtigsten Variablen aus `_variables.scss`:

- **Farben**: `$primary-color`, `$secondary-color`, etc.
- **Abstände**: `$spacing-xs` bis `$spacing-xxl`
- **Border Radius**: `$radius-sm` bis `$radius-pill`
- **Breakpoints**: `$breakpoint-sm` bis `$breakpoint-xxl`
- **Typografie**: `$font-size-base`, `$font-family-base`, etc.

## Verfügbare Mixins

- `@include responsive('md')` - Responsive Breakpoints
- `@include flex-center` - Flexbox Zentrierung
- `@include card-shadow()` - Karten-Schatten
- `@include button-style()` - Button-Styles

## Beispiel-Verwendung

```scss
.my-component {
    padding: $spacing-lg;
    background: $bg-white;
    border-radius: $radius-md;
    @include card-shadow();
    
    @include responsive('md') {
        padding: $spacing-md;
    }
    
    .my-button {
        @include button-style($primary-color, $primary-dark);
    }
}
```