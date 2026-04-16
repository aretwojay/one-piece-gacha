import "./bootstrap";

const rarityAnimationClassMap = {
    rare: "gacha-rarity-rare",
    epic: "gacha-rarity-epic",
    legendary: "gacha-rarity-legendary",
};

const rarityRevealClassMap = {
    rare: ["text-emerald-600", "dark:text-emerald-200"],
    epic: ["text-cyan-600", "dark:text-cyan-200"],
    legendary: ["text-amber-600", "dark:text-amber-100"],
};

const rarityLabelMap = {
    rare: "RARE",
    epic: "EPIC",
    legendary: "LEGENDARY",
};

const allRarityAnimationClasses = Object.values(rarityAnimationClassMap);
const allRarityRevealClasses = Object.values(rarityRevealClassMap).flat();

const normalizeRarity = (rarity) => {
    if (typeof rarity !== "string") {
        return "rare";
    }

    const rarityKey = rarity.trim().toLowerCase();

    if (
        rarityKey === "legendary" ||
        rarityKey === "epic" ||
        rarityKey === "rare"
    ) {
        return rarityKey;
    }

    return "rare";
};

const wait = (durationInMs) => {
    return new Promise((resolve) => {
        window.setTimeout(resolve, durationInMs);
    });
};

document.addEventListener("DOMContentLoaded", () => {
    const pullAnimationRoot = document.querySelector("[data-gacha-pull-root]");

    if (!pullAnimationRoot || !(pullAnimationRoot instanceof HTMLElement)) {
        return;
    }

    const fetchCharacterUrl = pullAnimationRoot.dataset.fetchCharacterUrl;
    const resultUrl = pullAnimationRoot.dataset.resultUrl;
    const pullsLimit = Number.parseInt(
        pullAnimationRoot.dataset.pullsLimit || "10",
        10,
    );
    const loadingMessage = pullAnimationRoot.querySelector(
        "[data-loading-message]",
    );
    const pullsRemainingCount = pullAnimationRoot.querySelector(
        "[data-pulls-remaining-count]",
    );
    const pullsResetMessage = pullAnimationRoot.querySelector(
        "[data-pulls-reset-message]",
    );
    const rarityReveal = pullAnimationRoot.querySelector(
        "[data-rarity-reveal]",
    );
    const errorMessage = pullAnimationRoot.querySelector(
        "[data-error-message]",
    );
    const retryButton = pullAnimationRoot.querySelector("[data-retry-button]");
    const rarityBurst = pullAnimationRoot.querySelector("[data-rarity-burst]");

    if (!fetchCharacterUrl || !resultUrl) {
        return;
    }

    const updatePullAvailability = (remainingPulls, retryAfterSeconds = 0) => {
        const normalizedRemaining = Number.isFinite(remainingPulls)
            ? Math.max(0, Math.min(pullsLimit, Math.trunc(remainingPulls)))
            : 0;

        if (pullsRemainingCount instanceof HTMLElement) {
            pullsRemainingCount.textContent = String(normalizedRemaining);
        }

        if (!(pullsResetMessage instanceof HTMLElement)) {
            return;
        }

        if (retryAfterSeconds > 0) {
            const retryAfterMinutes = Math.ceil(retryAfterSeconds / 60);
            pullsResetMessage.textContent =
                "Prochain tirage disponible dans " +
                String(retryAfterMinutes) +
                " minute(s).";
            pullsResetMessage.classList.remove("hidden");

            return;
        }

        if (normalizedRemaining > 0) {
            pullsResetMessage.classList.add("hidden");
            pullsResetMessage.textContent = "";
        }
    };

    const applyRarityAnimation = (rarityKey) => {
        pullAnimationRoot.classList.remove(...allRarityAnimationClasses);
        pullAnimationRoot.classList.add(rarityAnimationClassMap[rarityKey]);

        if (loadingMessage instanceof HTMLElement) {
            loadingMessage.classList.add("hidden");
        }

        if (rarityReveal instanceof HTMLElement) {
            rarityReveal.classList.remove(
                "hidden",
                ...allRarityRevealClasses,
                "gacha-rarity-text-pop",
            );
            rarityReveal.classList.add(...rarityRevealClassMap[rarityKey]);
            rarityReveal.textContent = `Rareté ${rarityLabelMap[rarityKey]} détectée`;

            void rarityReveal.offsetWidth;
            rarityReveal.classList.add("gacha-rarity-text-pop");
        }

        if (rarityBurst instanceof HTMLElement) {
            rarityBurst.classList.remove("gacha-rarity-burst-active");
            void rarityBurst.offsetWidth;
            rarityBurst.classList.add("gacha-rarity-burst-active");
        }
    };

    const showErrorState = (message) => {
        const fallbackMessage =
            "Impossible de recuperer un personnage. Tu peux relancer le tirage.";

        if (loadingMessage instanceof HTMLElement) {
            loadingMessage.classList.add("hidden");
        }

        if (errorMessage instanceof HTMLElement) {
            errorMessage.textContent = message || fallbackMessage;
            errorMessage.classList.remove("hidden");
        }

        if (retryButton instanceof HTMLElement) {
            retryButton.classList.remove("hidden");
            retryButton.classList.add("inline-flex");
        }
    };

    const pullCharacter = async () => {
        try {
            const [response] = await Promise.all([
                fetch(fetchCharacterUrl, {
                    headers: {
                        Accept: "application/json",
                    },
                }),
                wait(1700),
            ]);

            if (!response.ok) {
                let serverMessage = "";
                let retryAfterSeconds = Number.parseInt(
                    response.headers.get("Retry-After") || "0",
                    10,
                );

                if (
                    response.headers
                        .get("content-type")
                        ?.includes("application/json")
                ) {
                    const errorPayload = await response
                        .json()
                        .catch(() => null);
                    serverMessage =
                        typeof errorPayload?.message === "string"
                            ? errorPayload.message
                            : "";

                    if (typeof errorPayload?.retry_after === "number") {
                        retryAfterSeconds = errorPayload.retry_after;
                    }
                }

                if (response.status === 429) {
                    updatePullAvailability(0, Math.max(1, retryAfterSeconds));
                }

                throw new Error(
                    serverMessage ||
                        "Impossible de recuperer un personnage. Tu peux relancer le tirage.",
                );
            }

            const payload = await response.json();

            if (!payload.id) {
                throw new Error("Character ID missing from payload.");
            }

            if (typeof payload.pulls_remaining === "number") {
                updatePullAvailability(payload.pulls_remaining);
            } else {
                const remainingFromHeaders = Number.parseInt(
                    response.headers.get("X-RateLimit-Remaining") || "0",
                    10,
                );

                updatePullAvailability(
                    Number.isFinite(remainingFromHeaders)
                        ? remainingFromHeaders
                        : 0,
                );
            }

            const rarityKey = normalizeRarity(payload.rarity);
            applyRarityAnimation(rarityKey);

            const revealDurationByRarity = {
                rare: 700,
                epic: 900,
                legendary: 1200,
            };

            await wait(revealDurationByRarity[rarityKey]);

            const redirectUrl = new URL(resultUrl, window.location.origin);
            redirectUrl.searchParams.set("character", String(payload.id));
            window.location.assign(redirectUrl.toString());
        } catch (error) {
            showErrorState(
                error instanceof Error
                    ? error.message
                    : "Impossible de recuperer un personnage. Tu peux relancer le tirage.",
            );
            console.error(error);
        }
    };

    pullCharacter();
});
