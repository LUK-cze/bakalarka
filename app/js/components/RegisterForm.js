// TODO: pořádné komentáře  
function RegisterForm({ onSwitchToLogin }) {
    // Stav pro uchování hodnot formuláře a chybových zpráv
    const [username, setUsername] = React.useState('');
    const [password, setPassword] = React.useState('');
    const [passwordConfirm, setPasswordConfirm] = React.useState('');
    const [error, setError] = React.useState('');
    const [successMsg, setSuccessMsg] = React.useState('');
    const [isRegistered, setIsRegistered] = React.useState(false);

    // Funkce pro odeslání formuláře
    const handleSubmit = (e) => {
        e.preventDefault();
        setError('');
        setSuccessMsg('');

        // Kontrola, zda se hesla shodují
        if (password !== passwordConfirm) {
            setError('Hesla se neshodují.');
            return;
        }

        // Odeslání dat na server
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        formData.append('password_confirm', passwordConfirm);

        // Odeslání požadavku na registraci
        fetch('index.php?action=register', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            // Pokud je registrace úspěšná, zobrazíme zprávu a nabídneme přechod na přihlášení
            if (data.success) {
                setSuccessMsg('Účet byl úspěšně vytvořen! Přejděte na přihlášení...');
                setIsRegistered(true);
            } else {
                setError(data.message || 'Registrace selhala.');
            }
        })
        .catch(() => setError('Chyba spojení se serverem.'));
    };

    // Vykreslení formuláře
    return (
        <div className="container d-flex justify-content-center align-items-center vh-100">
            <div className="card shadow p-4" style={{ width: '380px' }}>
                <h3 className="card-title text-center mb-4">Registrace</h3>
                {error && <div className="alert alert-danger py-2">{error}</div>}

                {/* 2. Podmíněné zobrazení: Pokud je zaregistrováno, ukaž zprávu a tlačítko 
                Tohle říka isRegistered ? -> ano je -> ukaž že účet byl vytvořen 
                Když podmínka nebyla true (aka :), tak ukaž formulář*/}
                {isRegistered ? (
                    <div className="text-center py-3">
                        <div className="alert alert-success py-3 mb-4">
                            {successMsg}
                        </div>
                        <button 
                            onClick={onSwitchToLogin} 
                            className="btn btn-primary w-100"
                        >
                            Přejít k přihlášení
                        </button>
                    </div>
                ) : (

                <>
                {/* Formulář pro registraci */}
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
                    <div className="mb-3">
                        <label className="form-label">Potvrzení hesla</label>
                        <input 
                            type="password" 
                            className="form-control" 
                            value={passwordConfirm} 
                            onChange={(e) => setPasswordConfirm(e.target.value)} 
                            required 
                        />
                    </div>
                    <button type="submit" className="btn btn-success w-100 mb-3">Zaregistrovat se</button>
                </form>

                <div className="text-center">
                    <small>Již máš účet? <a href="#" onClick={(e) => { e.preventDefault(); onSwitchToLogin(); }}>Přihlaš se</a></small>
                </div>
                </>
                )}
            </div>
        </div>
    );
}