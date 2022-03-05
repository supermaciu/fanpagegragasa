/**
 * Particle Cursor
 * Tworzy cząsteczki koło kursora
 */

var running;

particle_cursor_checkbox = document.getElementsByClassName("particle_cursor")[0];

if (typeof particle_cursor_checkbox != "undefined") {
    if (particle_cursor == 1) {
        particle_cursor_checkbox.checked = 1;
        running = true;
    } else {
        particle_cursor_checkbox.checked = 0;
        running = false;
    }
} else {
    if (particle_cursor == 1) {
        running = true;
    } else {
        running = false;
    }
}

$(document).ready(() => {
    $(".particle_cursor").click(() => {
        if ($(".particle_cursor").is(":checked")) {
            running = true;
        } else {
            running = false;
        }
    })
});

var window_width = window.innerWidth;
var window_height = window.innerHeight;

var body = document.body;
var html = document.documentElement;

var document_height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);

var cursor = {x: 0, y: 0};
var cursor_offset = {
    x: -20, y: document_height - 20
};

var particle_color = [173, 0, 179];
var particle_color_diff = 25;

var particles = [];
var particle_spawn_chance = 0.2;

var scroll_mouse_y = 0;

function isScrollable() {
    if (document_height > window_height) {
        return true;
    } else {
        return false;
    }
}

function setHeight() {
    if (isScrollable()) {
        document_height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
    } else {
        document_height = body.scrollHeight;
    }

    cursor_offset = {
        x: 0, y: document_height
    };
}

function init() {
    document.addEventListener("DOMContentLoaded", () => {
        setHeight();
        bindEvents();
        loop();
    });
}

function bindEvents() {
    document.addEventListener("mousemove", (e) => {
        cursor.x = e.clientX;
        cursor.y = e.clientY;
        
        if (running) {
            if (Math.random() <= particle_spawn_chance) {
                addParticle(cursor.x, scroll_mouse_y, particle_color);
            }
        }
        
        scroll_mouse_y = window.scrollY + cursor.y;
    });

    window.addEventListener("resize", () => {
        window_width = window.innerWidth;
        window_height = window.innerHeight;

        setHeight();
    });

    document.addEventListener('scroll', (e) => {
        scroll_mouse_y = window.scrollY + cursor.y;

        if (running) {
            if (Math.random() <= particle_spawn_chance) {
                addParticle(cursor.x, scroll_mouse_y, particle_color);
            }
        }
    })
}

function pickSimilarColor(color, range) {
    var rgb = [color[0], color[1], color[2]];

    for (let i = 0; i < rgb.length; i++) {
        var diff = Math.floor(Math.random() * range);

        if (rgb[i] - diff < 255) {
            rgb[i] = rgb[i] + ((Math.random() < 0.5 ? -1 : 1) * diff);
        }
    }

    return rgb;
}

function addParticle(x, y, color) {
    var particle = new Particle(x, y, color);
    particles.push(particle);
}

function updateParticles() {
    for (var i = 0; i < particles.length; i++) {
        particles[i].update();
    }
    
    for (var i = particles.length-1; i >= 0; i--) {
        if (particles[i].position.y >= document_height || particles[i].life_span < 0) {
            particles[i].delete();
            particles.splice(i, 1);
        }
    }
}

function loop() {
    requestAnimationFrame(loop);
    updateParticles();
}

class Particle {
    constructor(x, y, color) {

        this.particle_width = 30;
        this.particle_height = 30;

        this.max_life_span = 25;
        this.life_span = this.max_life_span;

        this.particle_color = pickSimilarColor(color, particle_color_diff);

        this.initial_styles = {
            "position": "absolute",
            "display": "block",
            "pointerEvents": "none",
            "z-index": "100",
            "will-change": "transform",

            "border-radius": "50%",
            "background-color": "rgb(" + this.particle_color[0] + ", " + this.particle_color[1] + ", " + this.particle_color[2] + ")",

            "width": this.particle_width + "px",
            "height": this.particle_height + "px"
        };

        this.velocity = {
            x: (Math.random() / 2),
            y: 1
        };

        this.acceleration = {
            x: 1,
            y: 1.1
        };

        this.position = { x: x - cursor_offset.x, y: y - cursor_offset.y};

        this.element = document.createElement("div");
        
        for (var key in this.initial_styles) {
            this.element.style[key] = this.initial_styles[key];
        }

        document.body.appendChild(this.element);

        this.update = function() {
            this.position.x += this.velocity.x;
            this.position.y += this.velocity.y;

            this.velocity.x *= this.acceleration.x;
            this.velocity.y *= this.acceleration.y;

            this.element.style.transform = "translate3d(" + this.position.x + "px," + this.position.y + "px, 0px)"
            + " scale(" + (this.life_span / this.max_life_span) + ", " + this.acceleration.y * (this.life_span / this.max_life_span) + ") ";

            this.life_span--;
        };

        this.delete = function() {
            this.element.parentNode.removeChild(this.element);
        };

    }
}

function applyProperties(target, properties) {
    for( var key in properties ) {
        target.style[key] = properties[key];
    }
}

init();