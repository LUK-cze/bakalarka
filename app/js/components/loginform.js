// TODO: pořádné komentáře  
function LoginForm({ onLoginSuccess, onSwitchToRegister }) {
    const [username, setUsername] = React.useState('');
    const [password, setPassword] = React.useState('');
    const [error, setError] = React.useState('');

    // Funkce pro odeslání formuláře
    const handleSubmit = (e) => {
        e.preventDefault();
        setError('');

        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        fetch('index.php?action=login', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                onLoginSuccess(data.username);
            } else {
                setError(data.message || 'Nesprávné přihlašovací údaje.');
            }
        })
        .catch(() => setError('Chyba spojení se serverem.'));
    };

    // Vykreslení formuláře
    return (
        <div className="container d-flex justify-content-center align-items-center vh-100">
            <div className="card shadow p-4" style={{ width: '380px' }}>
                <h3 className="card-title text-center mb-4">Přihlášení</h3>
                {error && <div className="alert alert-danger py-2">{error}</div>}
                
                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label className="form-label">Uživatelské jméno</label>
                        <input 
                            type="text" 
                            className="form-control" 
                            value={username} 
                            onChange={(e) => setUsername(e.target.value)} 
                            required 
                        />
                    </div>
                    <div className="mb-3">
                        <label className="form-label">Heslo</label>
                        <input 
                            type="password" 
                            className="form-control" 
                            value={password} 
                            onChange={(e) => setPassword(e.target.value)} 
                            required 
                        />
                    </div>
                    <button type="submit" className="btn btn-primary w-100 mb-3">Přihlásit se</button>
                </form>

                <div className="text-center">
                    <small>Nemáš účet? <a href="#" onClick={(e) => { e.preventDefault(); onSwitchToRegister(); }}>Zaregistruj se</a></small>
                </div>
            </div>
        </div>
    );
}