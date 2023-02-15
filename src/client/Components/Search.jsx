import {IconSearch} from "@tabler/icons-react";
import {useState} from "react";

export default function Search({onSearch, ...props}) {
    const [term, setTerm] = useState("");

    function handleChange(e) {
        e.preventDefault();

        setTerm(e.target.value);
    }

    function submit(e) {
        e.preventDefault();

        onSearch(term);
    }

    return (
        <div {...props}>
            <form onSubmit={submit}>
                <div className="flex w-full max-w-xs overflow-hidden rounded border bg-white">
                    <input
                        className="w-full px-3 py-2 outline-none"
                        placeholder="Search"
                        value={term}
                        onChange={handleChange}
                    />
                    <button className="flex items-center pr-2 text-slate-400" type="submit">
                        <IconSearch size={20} />
                    </button>
                </div>
            </form>
        </div>
    );
}
