import Vue from "vue";

export default class EventBus {
    constructor() {
        this.bus = new Vue();
    }

    emit(events, ...data) {
        this.wrapper(
            events,
            () => this.bus.$emit(events, ...data),
            value => this.bus.$emit(value, ...data)
        );
    }

    on(events, callback) {
        this.wrapper(
            events,
            () => this.bus.$on(events, callback),
            value => this.bus.$on(value, callback)
        );
    }

    wrapper(events, ifNotArray, otherwise) {
        if (!Array.isArray(events)) {
            ifNotArray();
            return;
        }

        for (const value of events) {
            otherwise(value);
        }
    }
}
