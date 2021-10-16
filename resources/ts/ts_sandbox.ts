const bob = "hey I'm bob";
const bob2 = () => {};
console.log(bob);

// compiling and variables

// All numbers can be integers or floats.
const a = 5.4321;
const a2: number = 5.4321;
const a3 = {
    x: 5.4321,
    y: 12,
};
const a4: { x: number; y: number } = {
    x: 5.4321,
    y: 12,
};

// Interfaces can be used to declare types too.
interface MyObj {
    x: number,
    y: number,
    z?: number, // Add a question mark for optional properties.
};
const a5: MyObj = {
    x: 5.4321,
    y: 12,
};


// function

const add = (x: number, y: number) => x + y;

// Can declare a type
type AddFunc = (x: number, y: number) => number;
const add2: AddFunc = (x: number, y: number) => x + y;

// unions


// casting


// any
