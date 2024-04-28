import { writable } from "svelte/store";

// the initial values gets set by the select value bindings
export const filter = writable({});
