
class Cache {
    static DEFAULT = 0;
    static JSON = 1;

    static map = new Map();

    static setSessionValue(key, value, type = Cache.DEFAULT) {
        if (type == Cache.JSON) {
            this.map.set(key, JSON.stringify(value));
        }
        else {
            this.map.set(key, value.toString());
        }
    }

    static getSessionValue(key, type = Cache.DEFAULT) {
        if (this.map.has(key)) {
            try {
                if (type == Cache.JSON) {
                    return JSON.parse(this.map.get(key));
                }
                else {
                    return this.map.get(key);
                }
            }
            catch (err) {
                return undefined;
            }
        }
        else {
            return undefined;
        }
    }

    static clearSession() {
        this.map.clear();
    }
}

function App() {

    const [showHome, setShowHome] = React.useState(true)

    const toggleShow = () => {
        setShowHome(!showHome)
    }

    return <>
        {showHome ? <Home onclickAddNew={toggleShow} /> : <AddNewClue onGoBack={toggleShow} />}

    </>
}

function AddNewClue({ onGoBack }) {

    const [answer, setAnswer] = React.useState('');
    const [clue, setClue] = React.useState('');
    const [type, setType] = React.useState('text');

    const [currentState, setCurrentState] = React.useState([])

    const [questionId, setQuestionId] = React.useState(0);
    const [clueList, setClueList] = React.useState([]);

    React.useEffect(() => {
        const list = Cache.getSessionValue('clues', Cache.JSON) || null;
        if (list) setClueList(list)
        const index = Number(Cache.getSessionValue('index', Cache.DEFAULT) || null);
        setQuestionId(index);

        console.log({ index })

        history.pushState({ id: 'create' }, "Add new Clue", "#create");
        window.addEventListener("popstate", function (event) {
            console.log('popped')
            if (location.pathname.includes('create/clue-game')) {
                console.log(questionId)
                onGoBack();
            }
        });
    }, [])

    const AddClue = () => {

        if (answer.length == 0) {
            showToast('Enter Answer First', 'bg-danger')
            return;
        }
        if (clue.length == 0 || clue.length < 4) {
            showToast('Enter A Valid Clue. Clue Word Count Minimum 4', 'bg-danger')
            return;
        }

        const existingItem = clueList.find((item) => item.questionId === questionId);

        const obj = {
            Grade: clueList.length == 0 ? "1" : '',
            Topic: "",
            Answer: existingItem ? '' : answer,
            ClueAudio: type === 'audio' ? clue : '',
            ClueText: type === 'text' ? clue : '',
            language: "english",
            ClueImage: type === 'image' ? clue : '',
            imageSize: null,
            textLimit: "128",
            questionId: questionId,
            uploadedImageSize: type === 'image' ? "150 x 150" : null,
        }

        setClueList([...clueList, obj])
        setCurrentState([...currentState, obj])
        Cache.setSessionValue('clues', [...clueList, obj], Cache.JSON)

        setClue('')

        showToast(`New Clue Added For Answer : ${answer}`, 'bg-success')
    }

    return <>

        <div className="modal-content bg-white p-5 rounded border border-secondary mt-5">
            <div className="modal-header">
                <h1 className="modal-title fs-5" id="exampleModalLabel">Add new Answer</h1>
            </div>
            <div className="modal-body">


                <div className="mb-3">
                    <label htmlFor="exampleInputEmail1" className="form-label">Answer *</label>
                    <input type="text" className="form-control" value={answer} onChange={(e) => setAnswer(e.target.value)} />
                </div>

            </div>

        </div>
        <h4 className="mt-3"> Clues </h4>
        <div className="modal-content d-flex flex-row justify-content-center align-items-center flex-wrap bg-white p-2 rounded border border-secondary" >
            {
                currentState.map((clue, index) => {
                    return <div className="d-flex align-items-center bg-white p-3 mb-2 rounded border border-secondary w-100 question">
                        <div className="mr-5 d-flex justify-content-center align-items-center bg-secondary text-white rounded border border-secondary"
                            style={{
                                width: '40px',
                                height: '40px'
                            }}>
                            {index + 1}
                        </div>
                        {clue.ClueText && <p  >{clue.ClueText} </p>}
                        {clue.ClueImage && <img src={clue.ClueImage} width={50} height={50} />}
                        {clue.ClueAudio && <audio src={clue.ClueAudio} controls />}

                    </div>
                })
            }
        </div>

        <div className="modal-content bg-white p-5 mt-5 rounded border border-secondary">
            <div className="mb-3">
                <label htmlFor="exampleInputEmail1" className="form-label">Clue Type*</label>
                <select name="type" onChange={(e) => setType(e.target.value)} className="form-select" aria-label="Default select example">
                    <option value="text">Text</option>
                    <option value="image">Image</option>
                    <option value="audio">Audio</option>
                </select>
            </div>
            <div className="mb-3">
                <label htmlFor="exampleInputEmail1" className="form-label" id="clue">Clue *</label>
                <div>
                    <textarea className="form-control" value={clue} placeholder="Enter a Clue" onChange={(e) => setClue(e.target.value)} ></textarea>
                </div>
            </div>
            <div className="modal-footer">
                <button type="button" className="btn btn-primar mr-5" onClick={() => {
                    Cache.setSessionValue('index', questionId + 1, Cache.DEFAULT)
                    onGoBack();
                }} >Go Back</button>
                <button type="button" className="btn btn-primary" onClick={AddClue} >Add Clue</button>
            </div>

        </div>
    </>
}

function Home({ onclickAddNew }) {


    const [title, setTitle] = React.useState('')

    const [clueList, setClueList] = React.useState([]);

    const onCreate = async () => {

        if (title.length === 0) return showToast('Please Enter a Title', 'bg-danger')

        if (clueList.length == 0) return showToast('Please Add Clues & Answers', 'bg-danger')

        if (clueList.length < 2) return showToast('Please Add Atleast Two Clues / Answers', 'bg-danger')

        showLoader()

        let clues = Cache.getSessionValue('clues', Cache.JSON) || null;

        if (!clues) return showToast('Sorry No clues Found , Please Try again', 'bg-danger')


        clues[0].Topic = title
        // clues = clues.filter(i => i.Topic = title)

        const sendJSON = JSON.stringify({
            type: 'clue-game',
            'datablank': JSON.stringify(clues)
        })
        console.log(sendJSON)

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var headers = {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        };

        const form = new FormData();
        form.append('data', sendJSON)
        form.append('type', 'clue-game')

        showLoader()
        
        const req = await fetch(window.location.href, {
            method: 'POST',
            body: JSON.stringify({
                data: sendJSON,
                type: 'clue-game',
            }),
            headers: headers,
        })
        const res = await req.json()
        
        if (res.success) {
            showToast('created to new Excercise', 'bg-success')
            showLoader(false)
            
            var link = document.createElement("a"); // Or maybe get it from the current document
            link.href = '../../../teacher/assignment/view/' + res.id +"?teacher=true";
            link.target = '_blank'
            document.body.appendChild(link);
            link.click();
        }
    }

    React.useEffect(() => {
        console.log(title)
        Cache.setSessionValue('title', title, Cache.DEFAULT)
    }, [title])

    React.useEffect(() => {
        console.log(Cache.getSessionValue('title', Cache.DEFAULT) || 'title not found')
        const list = Cache.getSessionValue('clues', Cache.JSON) || null;
        if (list) {
            const groupedData = [];

            list.forEach((obj) => {
                const questionId = obj.questionId;
                const existingItem = groupedData.find((item) => item.questionId === questionId);

                if (existingItem) {
                    // If an item with the same questionId exists, add the object's data to the existing item's data array
                    existingItem.data.push(obj);
                } else {
                    // If no item with the same questionId exists, create a new item and add the object's data
                    const newItem = {
                        questionId: questionId,
                        data: [obj]
                    };
                    groupedData.push(newItem);
                }
            });
            console.log(groupedData)
            setClueList(groupedData)
        }
        console.log(JSON.stringify(list))
        const index = Cache.getSessionValue('index', Cache.DEFAULT) || null;
        if (index == null) Cache.setSessionValue('index', 0, Cache.DEFAULT)

    }, [])

    return <>
        <Header />
        <TopicTitle title={title} setTitle={setTitle} />
        <div className="d-flex justify-content-center align-items-center">
            <div className="add-answer bg-white mb-5 rounded w-50 border border-secondary d-flex justify-content-center align-items-center" onClick={onclickAddNew}>
                <h6>+ Add Answer</h6>
            </div>
        </div>
        <div className="d-flex align-items justify-content-center flex-wrap" id="list">
            {clueList.map((clue, i) => <ListClue clue={clue} index={i} key={i} />)}
        </div>

        <Footer onCreate={onCreate} />
    </>

}
function ListClue({ clue, index }) {
    return <div className="d-flex align-items-center bg-white p-3 mb-5 rounded border border-secondary w-100 question">
        <div className="mr-5 d-flex justify-content-center align-items-center bg-secondary text-white rounded border border-secondary"
            style={{
                width: '40px',
                height: '40px'
            }}>
            {index + 1}
        </div>
        <p  >{clue.data[0].Answer} ({clue.data.length} Clues)</p>
    </div>
}
function TopicTitle({ title, setTitle }) {
    return <div className="d-flex justify-content-center align-items-center">
        <div className="bg-white p-5 mb-5 rounded border border-secondary w-50">
            <div className="modal-body">
                <div className="mb-3">
                    <label htmlFor="exampleInputEmail1" className="form-label">Game Topic Title *</label>
                    <input type="text" className="form-control" value={title} onChange={(e) => setTitle(e.target.value)} aria-describedby="emailHelp" />
                </div>
            </div>

        </div>
    </div>
}

function Header() {
    return <div id="header" className="d-flex justify-content-center">
        <h1 className="jumbotron text-primary">Create Clue Game</h1>
    </div>
}

function Footer({ onCreate }) {
    return <div className="d-flex justify-content-center w100 mt-5 mb-5">
        <div className="button" onClick={onCreate} >
            Preview
            <div></div>
        </div>
    </div>
}


const container = document.getElementById('root');
const root = ReactDOM.createRoot(container);
root.render(<App />)