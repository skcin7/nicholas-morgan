interface ComponentInterface {
    componentName(): string;
};

class BaseComponent implements ComponentInterface {
    componentName(): string {
        //return this.component_name;
        return "";
    }
}
