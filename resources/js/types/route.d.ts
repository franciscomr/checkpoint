declare global {
    function route(routeName: string, parameters?: any[] | any, absolute?: boolean): string;
}

export {}; // Important for ensuring it's treated as a module
