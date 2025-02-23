class GoogleMapHandler {
    constructor() {
        this.map = null;
        this.markers = [];
        this.place = null
    }

    setMapElement(elementId) {
        this.map = new google.maps.Map(document.getElementById(elementId), {
            center: { lat: -14.235, lng: -51.9253 }, // Centro do Brasil
            zoom: 4
        });
    }

    addMarker(lat, lng) {
        if (!this.map) {
            console.error("O mapa ainda não foi inicializado.");
            return;
        }

        let marker = new google.maps.Marker({
            position: { lat: parseFloat(lat), lng: parseFloat(lng) },
            map: this.map,
            title: this.generateRandomMarkerId()
        });

        this.markers.push(marker);
    }

    addMultipleMarkers(locations) {
        locations.forEach(loc => this.addMarker(loc.lat, loc.lng, loc.title));
    }

    clearMarkers() {
        this.markers.forEach(marker => marker.setMap(null));
        this.markers = [];
    }

    setZoomAndCenter(lat, lng, zoom = 12) {
        if (!this.map) {
            console.error("O mapa ainda não foi inicializado.");
            return;
        }

        this.map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
        this.map.setZoom(zoom);
    }

    setZoom(zoom) {
        this.map.setZoom(zoom);
    }


    autoComplete(inputId, callback) {
        const instance = this;
        const input = document.getElementById(inputId);
        const autocomplete = new google.maps.places.Autocomplete(input, {
            types: ["geocode"],
            componentRestrictions: { country: "BR" }
        });

        autocomplete.addListener("place_changed", function () {
            const place = autocomplete.getPlace();
            instance.place = place
            callback(place)
        });
    }

    getAddressComponent(type, short = false) {
        if (this.place) {
            let component = this.place.address_components.find(c => c.types.includes(type));
            if (component) {
                return short ? component.short_name || "" : component.long_name || "";
            }
        }

        return "";
    }

    generateRandomMarkerId() {
        const prefix = "Marker_";
        const randomNumber = Math.floor(Math.random() * 10000);  // Gera um número aleatório de 4 dígitos
        return prefix + randomNumber;
    }

    fitMapToMarkers() {
        if (!this.map) {
            console.error("O mapa ainda não foi inicializado.");
            return;
        }

        const bounds = new google.maps.LatLngBounds();

        // Adiciona as coordenadas de cada marcador ao bounds
        this.markers.forEach(marker => {
            bounds.extend(marker.getPosition());
        });

        // Ajusta o zoom do mapa para mostrar todos os marcadores
        this.map.fitBounds(bounds);
    }
}